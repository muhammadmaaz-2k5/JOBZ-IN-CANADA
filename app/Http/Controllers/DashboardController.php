<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('employer')) {
            return redirect()->route('employer.dashboard');
        }

        return redirect()->route('seeker.dashboard');
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function employer()
    {
        // Load employer profile and company details
        $employerProfile = Auth::user()->employerProfile()->with('company')->first();
        return view('dashboard.employer', compact('employerProfile'));
    }

    public function seeker()
    {
        // Load job seeker profile details
        $seekerProfile = Auth::user()->jobSeekerProfile()->first();
        return view('dashboard.seeker', compact('seekerProfile'));
    }
}
