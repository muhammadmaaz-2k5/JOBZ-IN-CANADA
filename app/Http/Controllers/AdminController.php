<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use App\Models\JobReport;
use App\Models\ReportsLog;
use App\Models\CompanyReview;
use App\Models\Notification;
use App\Models\AuditLog;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ==========================================
    // 1. USER MANAGEMENT
    // ==========================================
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot suspend yourself.');
        }

        $newStatus = $user->status === 'suspended' ? 'active' : 'suspended';
        $user->update(['status' => $newStatus]);

        AuditLogHelper::log(Auth::id(), 'user_status_changed', "Changed status of User ID {$user->id} to {$newStatus}.");

        return redirect()->back()->with('success', "User status updated to {$newStatus}.");
    }

    public function resetUserPassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        AuditLogHelper::log(Auth::id(), 'user_password_reset', "Reset password for User ID {$user->id}.");

        return redirect()->back()->with('success', 'User password reset successfully.');
    }

    public function impersonateUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot impersonate yourself.');
        }

        // Save original admin ID in session
        session(['impersonator_id' => Auth::id()]);

        // Login as target user
        Auth::login($user);

        AuditLogHelper::log(session('impersonator_id'), 'impersonation_started', "Started impersonation of User ID {$user->id}.");

        return redirect()->route('dashboard')->with('success', "You are now impersonating {$user->first_name}.");
    }

    public function revertImpersonation()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        $adminId = session()->pull('impersonator_id');
        $admin = User::findOrFail($adminId);

        AuditLogHelper::log($admin->id, 'impersonation_ended', 'Ended impersonation session.');

        Auth::login($admin);

        return redirect()->route('admin.users.index')->with('success', 'Returned to Admin Panel.');
    }


    // ==========================================
    // 2. COMPANY MANAGEMENT
    // ==========================================
    public function companies(Request $request)
    {
        $query = Company::query();

        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('company_name', 'like', "%{$request->search}%");
        }

        $companies = $query->latest()->paginate(10)->withQueryString();

        return view('admin.companies', compact('companies'));
    }

    public function verifyCompany(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $request->validate([
            'status' => ['required', 'string', 'in:verified,rejected,pending'],
        ]);

        $company->update([
            'verification_status' => $request->status,
        ]);

        AuditLogHelper::log(Auth::id(), 'company_verification_changed', "Changed verification status of Company ID {$company->id} to {$request->status}.");

        return redirect()->back()->with('success', "Company verification status updated to {$request->status}.");
    }

    public function toggleCompanyStatus($id)
    {
        $company = Company::findOrFail($id);
        // Toggling verification to pending is a form of suspension
        $newStatus = $company->verification_status === 'suspended' ? 'pending' : 'suspended';
        $company->update(['verification_status' => $newStatus]);

        AuditLogHelper::log(Auth::id(), 'company_suspended', "Toggled status of Company ID {$company->id} to {$newStatus}.");

        return redirect()->back()->with('success', "Company status changed to {$newStatus}.");
    }


    // ==========================================
    // 3. JOB LISTINGS MODERATION
    // ==========================================
    public function jobs(Request $request)
    {
        $query = Job::with(['company', 'employer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.jobs', compact('jobs'));
    }

    public function approveJob($id)
    {
        $job = Job::findOrFail($id);
        $job->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        AuditLogHelper::log(Auth::id(), 'job_approved', "Approved job listing: {$job->title}");

        return redirect()->back()->with('success', 'Job posting approved and published.');
    }

    public function rejectJob($id)
    {
        $job = Job::findOrFail($id);
        $job->update([
            'status' => 'closed',
        ]);

        AuditLogHelper::log(Auth::id(), 'job_rejected', "Rejected job listing: {$job->title}");

        return redirect()->back()->with('success', 'Job posting rejected and closed.');
    }

    public function featureJob($id)
    {
        $job = Job::findOrFail($id);
        $job->update([
            'featured' => !$job->featured,
        ]);

        $status = $job->featured ? 'featured' : 'unfeatured';
        AuditLogHelper::log(Auth::id(), 'job_featured_toggle', "Toggled featured on job listing: {$job->title} to {$status}");

        return redirect()->back()->with('success', "Job posting marked as {$status}.");
    }

    public function urgentJob($id)
    {
        $job = Job::findOrFail($id);
        $job->update([
            'urgent' => !$job->urgent,
        ]);

        $status = $job->urgent ? 'urgent' : 'normal';
        AuditLogHelper::log(Auth::id(), 'job_urgent_toggle', "Toggled urgent on job listing: {$job->title} to {$status}");

        return redirect()->back()->with('success', "Job posting marked as {$status}.");
    }

    public function deleteJob($id)
    {
        $job = Job::findOrFail($id);
        $title = $job->title;
        $job->delete();

        AuditLogHelper::log(Auth::id(), 'job_deleted', "Deleted job listing: {$title}");

        return redirect()->back()->with('success', 'Job listing deleted successfully.');
    }


    // ==========================================
    // 4. CATEGORIES MANAGEMENT
    // ==========================================
    public function categories()
    {
        $categories = Category::with('parent')->latest()->get();
        $parentCategories = Category::whereNull('parent_id')->get();
        
        return view('admin.categories', compact('categories', 'parentCategories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
        ]);

        AuditLogHelper::log(Auth::id(), 'category_created', "Created job category: {$category->name}");

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name,' . $id],
            'parent_id' => ['nullable', 'exists:categories,id', 'different:id'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
        ]);

        AuditLogHelper::log(Auth::id(), 'category_updated', "Updated job category: {$category->name}");

        return redirect()->back()->with('success', 'Category updated.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        AuditLogHelper::log(Auth::id(), 'category_deleted', "Deleted job category: {$name}");

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }


    // ==========================================
    // 5. SKILLS MANAGEMENT
    // ==========================================
    public function skills(Request $request)
    {
        $query = Skill::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $skills = $query->latest()->paginate(15)->withQueryString();
        $allSkillsList = Skill::all(); // for merge dropdown list

        return view('admin.skills', compact('skills', 'allSkillsList'));
    }

    public function storeSkill(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:skills,name'],
        ]);

        $skill = Skill::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        AuditLogHelper::log(Auth::id(), 'skill_created', "Created platform skill: {$skill->name}");

        return redirect()->back()->with('success', 'Skill created successfully.');
    }

    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:skills,name,' . $id],
        ]);

        $skill->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        AuditLogHelper::log(Auth::id(), 'skill_updated', "Updated platform skill: {$skill->name}");

        return redirect()->back()->with('success', 'Skill updated.');
    }

    public function mergeSkills(Request $request)
    {
        $request->validate([
            'source_skill_id' => ['required', 'exists:skills,id'],
            'target_skill_id' => ['required', 'exists:skills,id', 'different:source_skill_id'],
        ]);

        $source = Skill::findOrFail($request->source_skill_id);
        $target = Skill::findOrFail($request->target_skill_id);

        DB::transaction(function() use ($source, $target) {
            // Update job associations
            DB::table('job_skills')
                ->where('skill_id', $source->id)
                ->whereNotExists(function($q) use ($target) {
                    $q->select(DB::raw(1))
                      ->from('job_skills as js2')
                      ->whereRaw('js2.job_id = job_skills.job_id')
                      ->where('js2.skill_id', $target->id);
                })
                ->update(['skill_id' => $target->id]);
            
            DB::table('job_skills')->where('skill_id', $source->id)->delete();

            // Update user associations
            DB::table('user_skills')
                ->where('skill_id', $source->id)
                ->whereNotExists(function($q) use ($target) {
                    $q->select(DB::raw(1))
                      ->from('user_skills as us2')
                      ->whereRaw('us2.user_id = user_skills.user_id')
                      ->where('us2.skill_id', $target->id);
                })
                ->update(['skill_id' => $target->id]);

            DB::table('user_skills')->where('skill_id', $source->id)->delete();

            $source->delete();
        });

        AuditLogHelper::log(Auth::id(), 'skills_merged', "Merged skill {$source->name} into {$target->name}.");

        return redirect()->back()->with('success', 'Skills merged successfully.');
    }

    public function destroySkill($id)
    {
        $skill = Skill::findOrFail($id);
        $name = $skill->name;
        $skill->delete();

        AuditLogHelper::log(Auth::id(), 'skill_deleted', "Deleted platform skill: {$name}");

        return redirect()->back()->with('success', 'Skill deleted.');
    }


    // ==========================================
    // 6. REPORTED CONTENT MODERATION
    // ==========================================
    public function reports(Request $request)
    {
        $query = JobReport::with(['job.company', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        return view('admin.reports', compact('reports'));
    }

    public function takeReportAction(Request $request, $id)
    {
        $report = JobReport::findOrFail($id);
        $request->validate([
            'action' => ['required', 'string', 'in:warn_employer,ban_employer,remove_content,dismiss'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function() use ($request, $report) {
            // Update Report Status
            $report->update([
                'status' => $request->action === 'dismiss' ? 'dismissed' : 'reviewed',
            ]);

            // Add Reports Log entry
            ReportsLog::create([
                'user_id' => Auth::id(),
                'report_id' => $report->id,
                'action' => $request->action,
                'notes' => $request->notes,
            ]);

            // Handle actions
            $job = $report->job;
            if ($request->action === 'remove_content' && $job) {
                $job->update(['status' => 'closed']);
                AuditLogHelper::log(Auth::id(), 'job_moderation_removed', "Closed job listing ID {$job->id} due to report.");
            }

            if ($request->action === 'ban_employer' && $job && $job->employer) {
                $job->employer->update(['status' => 'suspended']);
                AuditLogHelper::log(Auth::id(), 'user_suspended', "Suspended employer ID {$job->employer->id} due to job listing abuse report.");
            }
        });

        return redirect()->back()->with('success', 'Report processed successfully.');
    }


    // ==========================================
    // 7. REVIEW MODERATION
    // ==========================================
    public function reviews(Request $request)
    {
        $query = CompanyReview::with(['company', 'user']);
        $reviews = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.reviews', compact('reviews'));
    }

    public function toggleReviewStatus($id)
    {
        $review = CompanyReview::findOrFail($id);
        // Delete or toggling review
        $review->delete(); // Or we can use soft deletes/hidden flag

        AuditLogHelper::log(Auth::id(), 'review_deleted', "Deleted company review ID {$id}.");

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }


    // ==========================================
    // 8. GLOBAL ANNOUNCEMENTS
    // ==========================================
    public function announcements()
    {
        return view('admin.announcements');
    }

    public function broadcastAnnouncement(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string'],
        ]);

        $users = User::all();

        DB::transaction(function() use ($users, $request) {
            foreach ($users as $u) {
                Notification::create([
                    'user_id' => $u->id,
                    'title' => $request->title,
                    'body' => $request->body,
                    'type' => 'announcement',
                    'data' => [
                        'type' => 'announcement',
                        'title' => $request->title,
                        'body' => $request->body,
                    ],
                    'is_read' => false,
                ]);
            }
        });

        AuditLogHelper::log(Auth::id(), 'announcement_broadcast', "Broadcasted global announcement: {$request->title}");

        return redirect()->back()->with('success', 'Platform announcement broadcasted to all users successfully.');
    }


    // ==========================================
    // 9. AUDIT LOGS
    // ==========================================
    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', 'like', "%{$request->action}%");
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        return view('admin.audit_logs', compact('logs'));
    }
}
