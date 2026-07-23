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
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // 2MB per gallery image
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

        // Upload Gallery Images
        if ($request->hasFile('gallery_images')) {
            $cultureData = $company->culture_data ?? [];
            if (!isset($cultureData['gallery'])) {
                $cultureData['gallery'] = [];
            }

            foreach ($request->file('gallery_images') as $image) {
                $result = \App\Services\CloudinaryService::upload($image, 'job-portal/company-gallery');
                if ($result) {
                    $cultureData['gallery'][] = [
                        'url' => $result['secure_url'],
                        'public_id' => $result['public_id'],
                        'caption' => 'Office Image'
                    ];
                }
            }

            $company->culture_data = $cultureData;
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
            'culture_data' => $company->culture_data,
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

    public function deleteGalleryImage($index)
    {
        $user = Auth::user();
        $employerProfile = $user->employerProfile;
        
        if (!$employerProfile || !$employerProfile->company) {
            return back()->with('error', 'Company not found.');
        }
        
        $company = $employerProfile->company;
        $cultureData = $company->culture_data ?? [];
        
        if (isset($cultureData['gallery']) && isset($cultureData['gallery'][$index])) {
            $image = $cultureData['gallery'][$index];
            
            // Delete from Cloudinary
            if (!empty($image['public_id'])) {
                \App\Services\CloudinaryService::delete($image['public_id']);
            }
            
            // Remove from array and reindex
            unset($cultureData['gallery'][$index]);
            $cultureData['gallery'] = array_values($cultureData['gallery']);
            
            $company->update(['culture_data' => $cultureData]);
            
            AuditLogHelper::log($user->id, 'gallery_image_deleted', 'Employer deleted a gallery image.');
            
            return back()->with('status', 'image-deleted')->with('success', 'Image successfully removed from gallery.');
        }

        return back()->with('error', 'Image not found.');
    }

    /**
     * Display the public company profile view.
     */
    public function publicProfile($slug)
    {
        $company = Company::where('slug', $slug)->firstOrFail();
        
        // Retrieve jobs and reviews
        $jobs = $company->jobs()->where('status', 'published')->latest()->get();
        $reviews = $company->reviews()->with('user')->latest()->get();
        
        $avgRating = $reviews->avg('rating') ?: 4.5; // fallback to 4.5
        $totalReviews = $reviews->count() ?: 12; // fallback to 12
        
        // Calculate rating breakdown (if no reviews, use fallback distribution)
        if ($reviews->count() > 0) {
            $ratingBreakdown = [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ];
            
            $ratingPercentages = [];
            foreach ($ratingBreakdown as $star => $count) {
                $ratingPercentages[$star] = round(($count / $totalReviews) * 100);
            }
        } else {
            $ratingPercentages = [5 => 75, 4 => 20, 3 => 5, 2 => 0, 1 => 0];
        }
        
        return view('company.show', compact('company', 'jobs', 'reviews', 'avgRating', 'totalReviews', 'ratingPercentages'));
    }

    /**
     * Display the public company listings view.
     */
    public function publicIndex()
    {
        $companies = Company::where('verification_status', 'verified')->latest()->paginate(12);
        return view('company.index', compact('companies'));
    }
}
