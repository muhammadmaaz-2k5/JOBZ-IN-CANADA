<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeekerProfileController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EmployerApplicantController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::post('/users/{id}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status');
    Route::post('/users/{id}/password-reset', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
    Route::post('/users/{id}/impersonate', [AdminController::class, 'impersonateUser'])->name('users.impersonate');

    // Company management
    Route::get('/companies', [AdminController::class, 'companies'])->name('companies.index');
    Route::post('/companies/{id}/verify', [AdminController::class, 'verifyCompany'])->name('companies.verify');
    Route::post('/companies/{id}/status', [AdminController::class, 'toggleCompanyStatus'])->name('companies.status');

    // Job management
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs.index');
    Route::post('/jobs/{id}/approve', [AdminController::class, 'approveJob'])->name('jobs.approve');
    Route::post('/jobs/{id}/reject', [AdminController::class, 'rejectJob'])->name('jobs.reject');
    Route::post('/jobs/{id}/feature', [AdminController::class, 'featureJob'])->name('jobs.feature');
    Route::post('/jobs/{id}/urgent', [AdminController::class, 'urgentJob'])->name('jobs.urgent');
    Route::delete('/jobs/{id}', [AdminController::class, 'deleteJob'])->name('jobs.delete');

    // Categories management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Skills management
    Route::get('/skills', [AdminController::class, 'skills'])->name('skills.index');
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
    Route::put('/skills/{id}', [AdminController::class, 'updateSkill'])->name('skills.update');
    Route::post('/skills/merge', [AdminController::class, 'mergeSkills'])->name('skills.merge');
    Route::delete('/skills/{id}', [AdminController::class, 'destroySkill'])->name('skills.destroy');

    // Reports moderation
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::post('/reports/{id}/action', [AdminController::class, 'takeReportAction'])->name('reports.action');

    // Review moderation
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::post('/reviews/{id}/status', [AdminController::class, 'toggleReviewStatus'])->name('reviews.status');

    // Broadcast announcements
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements.index');
    Route::post('/announcements', [AdminController::class, 'broadcastAnnouncement'])->name('announcements.broadcast');

    // Audit logs
    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit-logs.index');
});

// Revert impersonation
Route::post('/admin/impersonate/revert', [AdminController::class, 'revertImpersonation'])
    ->middleware('auth')
    ->name('admin.impersonate.revert');

Route::get('/employer/dashboard', [DashboardController::class, 'employer'])
    ->middleware(['auth', 'verified', 'role:employer'])
    ->name('employer.dashboard');

Route::get('/seeker/dashboard', [DashboardController::class, 'seeker'])
    ->middleware(['auth', 'verified', 'role:job_seeker'])
    ->name('seeker.dashboard');

// Public Job Search & Listings
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

// Seeker Profile Management
Route::middleware(['auth', 'verified', 'role:job_seeker'])->group(function () {
    Route::get('/seeker/profile', [SeekerProfileController::class, 'show'])->name('seeker.profile.edit');
    Route::put('/seeker/profile', [SeekerProfileController::class, 'update'])->name('seeker.profile.update');
    Route::post('/seeker/profile/resume', [SeekerProfileController::class, 'uploadResume'])->name('seeker.resume.upload');
    Route::get('/seeker/profile/resume/{id}/download', [SeekerProfileController::class, 'downloadResume'])->name('seeker.resume.download');
    Route::delete('/seeker/profile/resume/{id}', [SeekerProfileController::class, 'deleteResume'])->name('seeker.resume.delete');
    Route::post('/seeker/profile/resume/{id}/default', [SeekerProfileController::class, 'setDefaultResume'])->name('seeker.resume.default');
    Route::post('/seeker/profile/experience', [SeekerProfileController::class, 'addExperience'])->name('seeker.experience.add');
    Route::delete('/seeker/profile/experience/{id}', [SeekerProfileController::class, 'deleteExperience'])->name('seeker.experience.delete');
    Route::post('/seeker/profile/education', [SeekerProfileController::class, 'addEducation'])->name('seeker.education.add');
    Route::delete('/seeker/profile/education/{id}', [SeekerProfileController::class, 'deleteEducation'])->name('seeker.education.delete');
    Route::post('/seeker/profile/skills', [SeekerProfileController::class, 'syncSkills'])->name('seeker.skills.sync');
    Route::post('/seeker/profile/project', [SeekerProfileController::class, 'addProject'])->name('seeker.project.add');
    Route::delete('/seeker/profile/project/{id}', [SeekerProfileController::class, 'deleteProject'])->name('seeker.project.delete');
    Route::post('/seeker/profile/certification', [SeekerProfileController::class, 'addCertification'])->name('seeker.certification.add');
    Route::delete('/seeker/profile/certification/{id}', [SeekerProfileController::class, 'deleteCertification'])->name('seeker.certification.delete');

    // Application actions
    Route::get('/jobs/{slug}/apply', [ApplicationController::class, 'showApplyForm'])->name('jobs.apply');
    Route::post('/jobs/{slug}/apply', [ApplicationController::class, 'submitApplication'])->name('jobs.apply.submit');
    Route::get('/seeker/applications', [ApplicationController::class, 'seekerDashboard'])->name('seeker.applications.index');
    Route::get('/seeker/applications/{id}', [ApplicationController::class, 'show'])->name('seeker.applications.show');
    Route::post('/seeker/applications/{id}/withdraw', [ApplicationController::class, 'withdraw'])->name('seeker.applications.withdraw');
    Route::get('/seeker/applications/{id}/download', [ApplicationController::class, 'downloadResume'])->name('seeker.applications.download');

    // Alert Actions
    Route::post('/seeker/alerts', [DashboardController::class, 'storeAlert'])->name('seeker.alerts.store');
    Route::delete('/seeker/alerts/{id}', [DashboardController::class, 'destroyAlert'])->name('seeker.alerts.destroy');

    // Save/Bookmark Job
    Route::post('/jobs/{id}/save', [JobController::class, 'toggleSave'])->name('jobs.save');
});

// Employer Profile & Job Management
Route::middleware(['auth', 'verified', 'role:employer'])->group(function () {
    Route::get('/employer/profile', [EmployerProfileController::class, 'show'])->name('employer.profile.edit');
    Route::put('/employer/profile', [EmployerProfileController::class, 'update'])->name('employer.profile.update');
    
    // View jobs list
    Route::get('/employer/jobs', [EmployerJobController::class, 'index'])->name('employer.jobs.index');
    
    // Create, edit, and state actions (restricted by company_verified middleware)
    Route::middleware('company_verified')->group(function () {
        Route::get('/employer/jobs/create', [EmployerJobController::class, 'create'])->name('employer.jobs.create');
        Route::post('/employer/jobs', [EmployerJobController::class, 'store'])->name('employer.jobs.store');
        Route::get('/employer/jobs/{id}/edit', [EmployerJobController::class, 'edit'])->name('employer.jobs.edit');
        Route::put('/employer/jobs/{id}', [EmployerJobController::class, 'update'])->name('employer.jobs.update');
        Route::post('/employer/jobs/{id}/duplicate', [EmployerJobController::class, 'duplicate'])->name('employer.jobs.duplicate');
        Route::post('/employer/jobs/{id}/status', [EmployerJobController::class, 'changeStatus'])->name('employer.jobs.status');
        Route::delete('/employer/jobs/{id}', [EmployerJobController::class, 'destroy'])->name('employer.jobs.destroy');

        // Applicant Management
        Route::get('/employer/applicants', [EmployerApplicantController::class, 'index'])->name('employer.applicants.index');
        Route::get('/employer/applicants/job/{jobId}', [EmployerApplicantController::class, 'index'])->name('employer.applicants.job');
        Route::get('/employer/applicants/pipeline', [EmployerApplicantController::class, 'pipeline'])->name('employer.applicants.pipeline.all');
        Route::get('/employer/applicants/pipeline/job/{jobId}', [EmployerApplicantController::class, 'pipeline'])->name('employer.applicants.pipeline.job');
        Route::get('/employer/applicants/{id}', [EmployerApplicantController::class, 'show'])->name('employer.applicants.show');
        Route::post('/employer/applicants/{id}/status', [EmployerApplicantController::class, 'changeStatus'])->name('employer.applicants.status');
        Route::post('/employer/applicants/{id}/note', [EmployerApplicantController::class, 'addNote'])->name('employer.applicants.note');
        Route::get('/employer/applicants/{id}/download', [EmployerApplicantController::class, 'downloadResume'])->name('employer.applicants.download');
    });
});

// Settings & GDPR Management
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings.edit');
    Route::post('/settings/sessions/logout', [SettingsController::class, 'logoutOtherDevices'])->name('settings.sessions.logout');
    Route::get('/settings/download-data', [SettingsController::class, 'downloadGdprData'])->name('settings.download-data');
    Route::post('/settings/deactivate', [SettingsController::class, 'deactivateAccount'])->name('settings.deactivate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
