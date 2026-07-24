<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobSeekerProfile;
use App\Models\Resume;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\Project;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeekerProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $seekerProfile = $user->jobSeekerProfile()->firstOrCreate(['user_id' => $user->id]);
        $seekerProfile->calculateCompletionPercentage();

        $resumes = $user->resumes()->latest()->get();
        $experiences = $user->experiences()->latest()->get();
        $education = $user->education()->latest()->get();
        $skills = $user->skills()->get();
        $certifications = $user->certifications()->latest()->get();
        $projects = $user->projects()->latest()->get();
        
        $allSkills = Skill::all(); // master list

        return view('profile.seeker-edit', compact(
            'user', 'seekerProfile', 'resumes', 'experiences', 'education', 'skills', 'certifications', 'projects', 'allSkills'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $seekerProfile = $user->jobSeekerProfile()->firstOrCreate(['user_id' => $user->id]);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'headline' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'current_salary' => ['nullable', 'numeric'],
            'expected_salary' => ['nullable', 'numeric'],
            'notice_period' => ['nullable', 'string', 'max:100'],
            'employment_preference' => ['nullable', 'string', 'max:100'],
            'career_level' => ['nullable', 'string', 'max:100'],
            'work_authorization' => ['nullable', 'string', 'max:100'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'portfolio' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        // Upload Profile Photo to Cloudinary
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_public_id) {
                \App\Services\CloudinaryService::delete($user->profile_photo_public_id);
            }
            $result = \App\Services\CloudinaryService::upload($request->file('profile_photo'), 'job-portal/profile-images');
            if ($result) {
                $user->profile_photo = $result['secure_url'];
                $user->profile_photo_public_id = $result['public_id'];
            }
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'country' => $request->country,
            'city' => $request->city,
            'profile_photo' => $user->profile_photo,
            'profile_photo_public_id' => $user->profile_photo_public_id,
        ]);

        $seekerProfile->update($request->only([
            'headline', 'summary', 'current_salary', 'expected_salary', 'notice_period', 
            'employment_preference', 'career_level', 'work_authorization', 'linkedin', 'github', 'portfolio', 'website'
        ]));

        $seekerProfile->calculateCompletionPercentage();

        AuditLogHelper::log($user->id, 'profile_updated', 'Seeker updated profile details.');

        return redirect()->route('seeker.profile.edit')->with('status', 'profile-updated');
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'resume_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB max
        ]);

        $user = Auth::user();
        $file = $request->file('resume_file');
        
        // Securely store resume in Google Drive service layer
        $driveService = app(\App\Services\Storage\StorageManager::class)->drive();
        $uploadResult = $driveService->uploadDocument($file);

        if (!$uploadResult) {
            return redirect()->back()->withErrors(['resume_file' => 'Failed to upload document to Google Drive storage.']);
        }

        // If it's the first resume, make it default
        $isFirst = !$user->resumes()->exists();

        $path = $uploadResult['google_drive_file_id'] 
            ? 'resumes/' . $uploadResult['google_drive_file_id'] 
            : $uploadResult['file_path'];

        Resume::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'file_path' => $path,
            'google_drive_file_id' => $uploadResult['google_drive_file_id'],
            'original_name' => $uploadResult['original_name'],
            'mime_type' => $uploadResult['mime_type'],
            'extension' => $uploadResult['extension'],
            'file_size' => $uploadResult['file_size'],
            'is_default' => $isFirst,
            'uploaded_at' => now(),
        ]);

        $user->jobSeekerProfile->calculateCompletionPercentage();

        AuditLogHelper::log($user->id, 'resume_uploaded', 'Seeker uploaded a new resume: ' . $uploadResult['original_name']);

        return redirect()->route('seeker.profile.edit')->with('success', 'Resume uploaded successfully.');
    }

    public function downloadResume($id)
    {
        $user = Auth::user();
        $resume = $user->resumes()->findOrFail($id);

        if ($resume->google_drive_file_id) {
            $driveService = app(\App\Services\Storage\StorageManager::class)->drive();
            $content = $driveService->downloadDocument($resume->google_drive_file_id);
            if (!$content) {
                abort(404, 'Resume file not found on Google Drive.');
            }
            AuditLogHelper::log($user->id, 'resume_downloaded', 'Seeker downloaded resume: ' . $resume->original_name);
            return response($content, 200, [
                'Content-Type' => $resume->mime_type ?: 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $resume->original_name . '"',
            ]);
        }

        if (!Storage::disk('private')->exists($resume->file_path)) {
            abort(404, 'Resume file not found.');
        }

        AuditLogHelper::log($user->id, 'resume_downloaded', 'Seeker downloaded resume: ' . $resume->original_name);

        return Storage::disk('private')->download($resume->file_path, $resume->original_name);
    }

    public function deleteResume($id)
    {
        $user = Auth::user();
        $resume = $user->resumes()->findOrFail($id);

        // Delete from Google Drive or local storage
        if ($resume->google_drive_file_id) {
            $driveService = app(\App\Services\Storage\StorageManager::class)->drive();
            $driveService->deleteDocument($resume->google_drive_file_id);
        } else {
            Storage::disk('private')->delete($resume->file_path);
        }

        $resume->delete();

        // If default was deleted, make another one default
        if ($resume->is_default) {
            $nextResume = $user->resumes()->first();
            if ($nextResume) {
                $nextResume->update(['is_default' => true]);
            }
        }

        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Resume deleted.');
    }

    public function setDefaultResume($id)
    {
        $user = Auth::user();
        $user->resumes()->update(['is_default' => false]);
        
        $resume = $user->resumes()->findOrFail($id);
        $resume->update(['is_default' => true]);

        return redirect()->route('seeker.profile.edit')->with('success', 'Default resume updated.');
    }

    public function addExperience(Request $request)
    {
        $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'currently_working' => ['boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        
        Experience::create([
            'user_id' => $user->id,
            'company' => $request->company,
            'designation' => $request->designation,
            'employment_type' => $request->employment_type,
            'start_date' => $request->start_date,
            'end_date' => $request->currently_working ? null : $request->end_date,
            'currently_working' => $request->has('currently_working'),
            'description' => $request->description,
        ]);

        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Work experience added.');
    }

    public function deleteExperience($id)
    {
        $user = Auth::user();
        $user->experiences()->findOrFail($id)->delete();
        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Work experience deleted.');
    }

    public function addEducation(Request $request)
    {
        $request->validate([
            'institution' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'grade' => ['nullable', 'string', 'max:25'],
        ]);

        $user = Auth::user();

        Education::create([
            'user_id' => $user->id,
            'institution' => $request->institution,
            'degree' => $request->degree,
            'field_of_study' => $request->field_of_study,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'grade' => $request->grade,
        ]);

        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Education record added.');
    }

    public function deleteEducation($id)
    {
        $user = Auth::user();
        $user->education()->findOrFail($id)->delete();
        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Education record deleted.');
    }

    public function syncSkills(Request $request)
    {
        $user = Auth::user();
        
        // Sync skills using many-to-many user_skills table
        $skillsData = [];
        if ($request->has('skills')) {
            $inputSkills = $request->skills;
            
            // If it's a comma-separated string, explode it
            if (is_string($inputSkills)) {
                $skillNames = array_map('trim', explode(',', $inputSkills));
            } elseif (is_array($inputSkills)) {
                $skillNames = array_map('trim', $inputSkills);
            } else {
                $skillNames = [];
            }
            
            $skillNames = array_filter($skillNames);
            
            foreach ($skillNames as $name) {
                $skill = \App\Models\Skill::firstOrCreate(['name' => $name]);
                $skillsData[$skill->id] = [
                    'experience_years' => 1,
                    'proficiency' => 'intermediate'
                ];
            }
        }

        $user->skills()->sync($skillsData);
        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Skills updated.');
    }

    public function addProject(Request $request)
    {
        $request->validate([
            'project_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
        ]);

        $user = Auth::user();

        Project::create([
            'user_id' => $user->id,
            'project_name' => $request->project_name,
            'description' => $request->description,
            'technologies' => $request->technologies,
            'url' => $request->url,
        ]);

        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Project added.');
    }

    public function deleteProject($id)
    {
        $user = Auth::user();
        $user->projects()->findOrFail($id)->delete();
        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Project deleted.');
    }

    public function addCertification(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'credential_url' => ['nullable', 'url', 'max:255'],
        ]);

        $user = Auth::user();

        Certification::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'organization' => $request->organization,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
            'credential_url' => $request->credential_url,
        ]);

        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Certification added.');
    }

    public function deleteCertification($id)
    {
        $user = Auth::user();
        $user->certifications()->findOrFail($id)->delete();
        $user->jobSeekerProfile->calculateCompletionPercentage();

        return redirect()->route('seeker.profile.edit')->with('success', 'Certification deleted.');
    }

    /**
     * Display the interactive Resume Builder canvas.
     */
    public function resumeBuilder()
    {
        $user = Auth::user();
        $seekerProfile = $user->jobSeekerProfile()->firstOrCreate(['user_id' => $user->id]);

        $experiences = $user->experiences()->latest()->get();
        $education = $user->education()->latest()->get();
        $skills = $user->skills()->get();
        $projects = $user->projects()->latest()->get();
        $certifications = $user->certifications()->latest()->get();

        return view('seeker.resume-builder', compact(
            'user', 'seekerProfile', 'experiences', 'education', 'skills', 'projects', 'certifications'
        ));
    }
}
