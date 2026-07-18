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

        // Upload Logo
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $logoPath = $request->file('logo')->store('company_logos', 'public');
            $company->logo = $logoPath;
        }

        // Upload Cover Image
        if ($request->hasFile('cover_image')) {
            if ($company->cover_image) {
                Storage::disk('public')->delete($company->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('company_covers', 'public');
            $company->cover_image = $coverPath;
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
