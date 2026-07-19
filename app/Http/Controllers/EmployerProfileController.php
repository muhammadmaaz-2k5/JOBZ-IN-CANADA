<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployerProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $employerProfile = $user->employerProfile()->with('company')->firstOrCreate([
            'user_id' => $user->id
        ]);

        $company = $employerProfile->company;
        if (!$company) {
            // Create fallback dummy company if somehow missing
            $company = Company::create([
                'company_name' => $user->first_name . '\'s Organization',
                'slug' => Str::slug($user->first_name . '-org-' . uniqid()),
                'verification_status' => 'pending'
            ]);
            $employerProfile->update(['company_id' => $company->id]);
        }

        return view('profile.employer-edit', compact('user', 'employerProfile', 'company'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $employerProfile = $user->employerProfile()->firstOrCreate(['user_id' => $user->id]);
        $company = $employerProfile->company;

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            
            // Company Fields
            'company_name' => ['required', 'string', 'max:255'],
            'website' => ['required', 'url', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'max:100'],
            'founded_year' => ['nullable', 'integer', 'min:1700', 'max:' . date('Y')],
            'headquarters' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:25'],
            
            // Branding uploads
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // 2MB
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'], // 3MB
        ]);

        // Upload Logo to Cloudinary
        if ($request->hasFile('logo')) {
            if ($company->logo_public_id) {
                \App\Services\CloudinaryService::delete($company->logo_public_id);
            }
            $result = \App\Services\CloudinaryService::upload($request->file('logo'), 'job-portal/company-logos');
            if ($result) {
                $company->logo = $result['secure_url'];
                $company->logo_public_id = $result['public_id'];
            }
        }

        // Upload Cover Image to Cloudinary
        if ($request->hasFile('cover_image')) {
            if ($company->cover_image_public_id) {
                \App\Services\CloudinaryService::delete($company->cover_image_public_id);
            }
            $result = \App\Services\CloudinaryService::upload($request->file('cover_image'), 'job-portal/company-covers');
            if ($result) {
                $company->cover_image = $result['secure_url'];
                $company->cover_image_public_id = $result['public_id'];
            }
        }

        // Update Company
        $company->update([
            'company_name' => $request->company_name,
            'website' => $request->website,
            'industry' => $request->industry,
            'company_size' => $request->company_size,
            'founded_year' => $request->founded_year,
            'headquarters' => $request->headquarters,
            'description' => $request->description,
            'email' => $request->company_email,
            'phone' => $request->company_phone,
            'logo' => $company->logo,
            'logo_public_id' => $company->logo_public_id,
            'cover_image' => $company->cover_image,
            'cover_image_public_id' => $company->cover_image_public_id,
        ]);

        // Update User details
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        // Update Employer Profile
        $employerProfile->update([
            'designation' => $request->designation,
            'department' => $request->department,
            'phone' => $request->phone,
        ]);

        AuditLogHelper::log($user->id, 'company_updated', 'Employer updated company details for: ' . $company->company_name);

        return redirect()->route('employer.profile.edit')->with('status', 'profile-updated');
    }
}
