<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployerJobController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employerProfile = $user->employerProfile()->first();
        
        if (!$employerProfile || !$employerProfile->company_id) {
            return redirect()->route('employer.profile.edit')->with('warning', 'Please configure your company details first.');
        }

        $jobs = Job::where('company_id', $employerProfile->company_id)
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::all();
        $skills = Skill::all();
        
        return view('employer.jobs.create', compact('categories', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['required', 'string'],
            'benefits' => ['nullable', 'string'],
            'vacancies' => ['required', 'integer', 'min:1'],
            'employment_type' => ['required', 'string'],
            'workplace_type' => ['required', 'string'],
            'experience_level' => ['required', 'string'],
            'education_level' => ['required', 'string'],
            
            // Salary
            'salary_visibility' => ['required', 'string'],
            'currency' => ['required', 'string', 'max:10'],
            'min_salary' => ['nullable', 'numeric'],
            'max_salary' => ['nullable', 'numeric', 'gte:min_salary'],
            'salary_period' => ['required', 'string'],
            
            // Location
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'full_address' => ['nullable', 'string'],
            
            // Requirements
            'application_deadline' => ['nullable', 'date', 'after:today'],
            'max_applications' => ['nullable', 'integer', 'min:1'],
            'auto_close_on_deadline' => ['boolean'],
            'allow_cover_letter' => ['boolean'],
            'resume_required' => ['boolean'],
            'portfolio_required' => ['boolean'],
            
            'skills' => ['nullable', 'array'],
            'skills.*' => ['exists:skills,id'],
            'status' => ['required', 'string', 'in:draft,published'],
            'questions' => ['nullable', 'array'],
            'questions.*' => ['required', 'string', 'max:255'],
            'questions_required' => ['nullable', 'array'],
        ]);

        $user = Auth::user();
        $companyId = $user->employerProfile->company_id;

        $jobData = $request->except(['skills', '_token', 'questions', 'questions_required']);
        $jobData['company_id'] = $companyId;
        $jobData['employer_id'] = $user->id;
        $jobData['location'] = $request->city;
        $jobData['slug'] = Str::slug($request->title . '-' . uniqid());
        
        // Map form parameters to database columns
        $jobData['salary_min'] = $request->min_salary;
        $jobData['salary_max'] = $request->max_salary;
        $jobData['salary_type'] = $request->salary_period;

        $jobData['auto_close_on_deadline'] = $request->has('auto_close_on_deadline');
        $jobData['allow_cover_letter'] = $request->has('allow_cover_letter');
        $jobData['resume_required'] = $request->has('resume_required');
        $jobData['portfolio_required'] = $request->has('portfolio_required');
        $jobData['published_at'] = $request->status === 'published' ? now() : null;

        $job = Job::create($jobData);

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        if ($request->has('questions')) {
            foreach ($request->questions as $index => $qText) {
                if (!empty($qText)) {
                    $job->screeningQuestions()->create([
                        'question_text' => $qText,
                        'is_required' => isset($request->questions_required[$index]) && $request->questions_required[$index] == '1',
                    ]);
                }
            }
        }

        AuditLogHelper::log($user->id, 'job_created', "Employer created job listing: {$job->title}");

        return redirect()->route('employer.jobs.index')->with('success', 'Job posting created successfully.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $job = Job::where('employer_id', $user->id)->findOrFail($id);
        
        $categories = Category::all();
        $skills = Skill::all();
        $selectedSkills = $job->skills()->pluck('skills.id')->toArray();

        return view('employer.jobs.edit', compact('job', 'categories', 'skills', 'selectedSkills'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $job = Job::where('employer_id', $user->id)->findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['required', 'string'],
            'benefits' => ['nullable', 'string'],
            'vacancies' => ['required', 'integer', 'min:1'],
            'employment_type' => ['required', 'string'],
            'workplace_type' => ['required', 'string'],
            'experience_level' => ['required', 'string'],
            'education_level' => ['required', 'string'],
            
            // Salary
            'salary_visibility' => ['required', 'string'],
            'currency' => ['required', 'string', 'max:10'],
            'min_salary' => ['nullable', 'numeric'],
            'max_salary' => ['nullable', 'numeric', 'gte:min_salary'],
            'salary_period' => ['required', 'string'],
            
            // Location
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'full_address' => ['nullable', 'string'],
            
            // Requirements
            'application_deadline' => ['nullable', 'date'],
            'max_applications' => ['nullable', 'integer', 'min:1'],
            'auto_close_on_deadline' => ['boolean'],
            'allow_cover_letter' => ['boolean'],
            'resume_required' => ['boolean'],
            'portfolio_required' => ['boolean'],
            
            'skills.*' => ['exists:skills,id'],
            'status' => ['required', 'string', 'in:draft,published,paused,closed,archived'],
            'questions' => ['nullable', 'array'],
            'questions.*' => ['required', 'string', 'max:255'],
            'questions_required' => ['nullable', 'array'],
        ]);

        $jobData = $request->except(['skills', '_token', '_method', 'questions', 'questions_required']);
        $jobData['location'] = $request->city;
        
        // Map form parameters to database columns
        $jobData['salary_min'] = $request->min_salary;
        $jobData['salary_max'] = $request->max_salary;
        $jobData['salary_type'] = $request->salary_period;

        $jobData['auto_close_on_deadline'] = $request->has('auto_close_on_deadline');
        $jobData['allow_cover_letter'] = $request->has('allow_cover_letter');
        $jobData['resume_required'] = $request->has('resume_required');
        $jobData['portfolio_required'] = $request->has('portfolio_required');

        if ($request->status === 'published' && $job->status !== 'published') {
            $jobData['published_at'] = now();
        }

        $job->update($jobData);

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        } else {
            $job->skills()->detach();
        }

        // Update screening questions
        $job->screeningQuestions()->delete();
        if ($request->has('questions')) {
            foreach ($request->questions as $index => $qText) {
                if (!empty($qText)) {
                    $job->screeningQuestions()->create([
                        'question_text' => $qText,
                        'is_required' => isset($request->questions_required[$index]) && $request->questions_required[$index] == '1',
                    ]);
                }
            }
        }

        AuditLogHelper::log($user->id, 'job_updated', "Employer updated job listing: {$job->title}");

        return redirect()->route('employer.jobs.index')->with('success', 'Job posting updated.');
    }

    public function duplicate($id)
    {
        $user = Auth::user();
        $job = Job::where('employer_id', $user->id)->findOrFail($id);

        $newJob = $job->replicate();
        $newJob->title = $job->title . ' Copy';
        $newJob->slug = Str::slug($newJob->title . '-' . uniqid());
        $newJob->status = 'draft';
        $newJob->views_count = 0;
        $newJob->applications_count = 0;
        $newJob->published_at = null;
        $newJob->save();

        // Replicate skills associations
        $skills = $job->skills()->pluck('skills.id')->toArray();
        $newJob->skills()->sync($skills);

        AuditLogHelper::log($user->id, 'job_duplicated', "Employer duplicated job: {$job->title}");

        return redirect()->route('employer.jobs.index')->with('success', 'Job listing duplicated to draft.');
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:published,paused,closed,archived']
        ]);

        $user = Auth::user();
        $job = Job::where('employer_id', $user->id)->findOrFail($id);

        $job->update([
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : $job->published_at
        ]);

        AuditLogHelper::log($user->id, 'job_status_changed', "Changed status of job {$job->title} to {$request->status}");

        return redirect()->route('employer.jobs.index')->with('success', "Job status changed to {$request->status}.");
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $job = Job::where('employer_id', $user->id)->findOrFail($id);
        
        AuditLogHelper::log($user->id, 'job_deleted', "Employer deleted job listing: {$job->title}");

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job listing deleted.');
    }
}
