<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\JobSeekerProfile;
use App\Models\EmployerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'string', 'in:job_seeker,employer'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Job Seeker Profile Optional validation
            'headline' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],

            // Employer & Company validation
            'company_name' => ['required_if:role,employer', 'nullable', 'string', 'max:255'],
            'website' => ['required_if:role,employer', 'nullable', 'url', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:255'],
            'designation' => ['required_if:role,employer', 'nullable', 'string', 'max:255'],
            'employer_phone' => ['required_if:role,employer', 'nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Assign Spatie Role
        $user->assignRole($request->role);

        // Populate child tables
        if ($request->role === 'job_seeker') {
            JobSeekerProfile::create([
                'user_id' => $user->id,
                'headline' => $request->headline,
                'linkedin' => $request->linkedin,
                'profile_completion' => $request->headline ? 10 : 0,
            ]);
        } elseif ($request->role === 'employer') {
            // Generate unique slug for company
            $slug = Str::slug($request->company_name);
            $originalSlug = $slug;
            $count = 1;
            while (Company::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $company = Company::create([
                'company_name' => $request->company_name,
                'slug' => $slug,
                'website' => $request->website,
                'industry' => $request->industry,
                'company_size' => $request->company_size,
                'verification_status' => 'pending',
            ]);

            EmployerProfile::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'designation' => $request->designation,
                'phone' => $request->employer_phone,
            ]);
        }

        event(new Registered($user));

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
