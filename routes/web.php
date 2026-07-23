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
use App\Http\Controllers\CompanyReviewController;
use App\Http\Controllers\SearchSuggestionController;
use App\Http\Controllers\SearchAnalyticsController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RevenueAnalyticsController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/why-choose-us', function () {
    return view('why-choose-us');
})->name('why-choose-us');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

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

    // Search analytics
    Route::get('/search-analytics', [SearchAnalyticsController::class, 'index'])->name('search-analytics.index');

    // Coupons CRUD
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::post('/coupons/{id}/toggle', [CouponController::class, 'toggleStatus'])->name('coupons.toggle');
    Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');

    // Revenue analytics
    Route::get('/revenue-analytics', [RevenueAnalyticsController::class, 'index'])->name('revenue-analytics.index');
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

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/companies', [EmployerProfileController::class, 'publicIndex'])->name('companies.index');
Route::get('/companies/{slug}', [EmployerProfileController::class, 'publicProfile'])->name('companies.show');

// Seeker Profile Management
Route::middleware(['auth', 'verified', 'role:job_seeker'])->group(function () {
    Route::get('/seeker/profile', [SeekerProfileController::class, 'show'])->name('seeker.profile.edit');
    Route::get('/seeker/resume-builder', [SeekerProfileController::class, 'resumeBuilder'])->name('seeker.resume-builder');
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

    // Seeker Resume Boost
    Route::get('/seeker/boost', [BillingController::class, 'seekerBoost'])->name('seeker.boost.index');
    Route::post('/seeker/boost', [BillingController::class, 'boostProfile'])->name('seeker.boost.submit');

    // Notification Preferences
    Route::get('/profile/notifications', [\App\Http\Controllers\NotificationPreferenceController::class, 'edit'])->name('profile.notifications.edit');
    Route::put('/profile/notifications', [\App\Http\Controllers\NotificationPreferenceController::class, 'update'])->name('profile.notifications.update');

    // In-App Notifications
    Route::get('/notifications', [\App\Http\Controllers\InAppNotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\InAppNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\InAppNotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Employer Profile & Job Management
Route::middleware(['auth', 'verified', 'role:employer'])->group(function () {
    Route::get('/employer/profile', [EmployerProfileController::class, 'show'])->name('employer.profile.edit');
    Route::put('/employer/profile', [EmployerProfileController::class, 'update'])->name('employer.profile.update');
    Route::delete('/employer/profile/gallery/{index}', [EmployerProfileController::class, 'deleteGalleryImage'])->name('employer.profile.gallery.delete');
    
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

        // Premium Candidate Database Search
        Route::get('/employer/candidates', [EmployerApplicantController::class, 'searchCandidates'])->middleware('premium_search')->name('employer.candidates.search');
        Route::get('/employer/candidates/{id}', [EmployerApplicantController::class, 'showCandidate'])->middleware('premium_search')->name('employer.candidates.show');
        Route::get('/employer/candidates/{id}/download-resume', [EmployerApplicantController::class, 'downloadCandidateResume'])->middleware('premium_search')->name('employer.candidates.download-resume');
    });

    // Employer Billing & Subscriptions
    Route::get('/employer/billing', [BillingController::class, 'employerBilling'])->name('employer.billing.index');
    Route::post('/employer/billing/subscribe', [BillingController::class, 'subscribe'])->name('employer.billing.subscribe');
    Route::post('/employer/billing/cancel', [BillingController::class, 'cancelSubscription'])->name('employer.billing.cancel');
    
    // Job Promotions
    Route::get('/employer/jobs/{id}/promote', [BillingController::class, 'showPromoteForm'])->name('employer.jobs.promote');
    Route::post('/employer/jobs/{id}/promote', [BillingController::class, 'promoteJob'])->name('employer.jobs.promote.submit');
});

// Settings & GDPR Management
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings.edit');
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages.index');
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

// Public Search Suggestions Autocomplete API
Route::get('/api/jobs/suggestions', [SearchSuggestionController::class, 'index'])->name('api.jobs.suggestions');

// History Session Clearing Actions
Route::post('/jobs/history/clear-search', [JobController::class, 'clearSearchHistory'])->name('jobs.history.clear-search');
Route::post('/jobs/history/clear-viewed', [JobController::class, 'clearViewedHistory'])->name('jobs.history.clear-viewed');

// Public Company Review
Route::post('/companies/{company:slug}/reviews', [CompanyReviewController::class, 'store'])->name('companies.reviews.store')->middleware('auth');


// Dynamic XML Sitemap Generator
Route::get('/sitemap.xml', function () {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Add static/core pages
    $xml .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
    $xml .= '<url><loc>' . url('/jobs') . '</loc><changefreq>hourly</changefreq><priority>0.9</priority></url>';
    
    // Add active jobs
    $jobs = \App\Models\Job::where('status', 'published')->get();
    foreach ($jobs as $j) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('jobs.show', $j->slug) . '</loc>';
        $xml .= '<lastmod>' . ($j->updated_at ? $j->updated_at->toAtomString() : $j->created_at->toAtomString()) . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

// Secure Invoice Details Page
Route::get('/invoices/{invoice_number}', [BillingController::class, 'showInvoice'])->middleware('auth')->name('invoices.show');

// Design System Showcase Dashboard
Route::get('/design-system', [\App\Http\Controllers\DesignSystemController::class, 'index'])->name('design-system');
