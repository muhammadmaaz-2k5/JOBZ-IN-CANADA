<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeekerProfileController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.dashboard');

Route::get('/employer/dashboard', [DashboardController::class, 'employer'])
    ->middleware(['auth', 'verified', 'role:employer'])
    ->name('employer.dashboard');

Route::get('/seeker/dashboard', [DashboardController::class, 'seeker'])
    ->middleware(['auth', 'verified', 'role:job_seeker'])
    ->name('seeker.dashboard');

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
});

// Employer Profile Management
Route::middleware(['auth', 'verified', 'role:employer'])->group(function () {
    Route::get('/employer/profile', [EmployerProfileController::class, 'show'])->name('employer.profile.edit');
    Route::put('/employer/profile', [EmployerProfileController::class, 'update'])->name('employer.profile.update');
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
