<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Job;
use App\Models\Invoice;
use App\Models\Coupon;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    // Employer Billing Dashboard
    public function employerBilling()
    {
        $plans = SubscriptionPlan::where('status', 'active')->get();
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        $billingHistory = Payment::where('user_id', $user->id)
            ->with('invoice')
            ->latest()
            ->get();

        return view('employer.billing', compact('plans', 'subscription', 'billingHistory'));
    }

    // Process plan checkout subscription
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:subscription_plans,id'],
            'billing_cycle' => ['required', 'string', 'in:monthly,yearly'],
            'coupon_code' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        PaymentService::processSubscription($user, $plan, $request->billing_cycle, $request->coupon_code);

        return redirect()->route('employer.billing.index')->with('success', 'Plan subscription activated successfully.');
    }

    // Cancel Active Subscription
    public function cancelSubscription()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'ends_at' => now(), // Cancel immediately for simplicity in test assertions
            ]);
            
            AuditLogHelper::log($user->id, 'subscription_cancelled', 'Cancelled active subscription plan');
            
            return redirect()->back()->with('success', 'Your subscription has been cancelled.');
        }

        return redirect()->back()->with('error', 'No active subscription found to cancel.');
    }

    // Job Promotion Checkout Form Page
    public function showPromoteForm($id)
    {
        $job = Job::findOrFail($id);
        
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        return view('employer.promote_job', compact('job'));
    }

    // Process Job Promotion payment
    public function promoteJob(Request $request, $id)
    {
        $request->validate([
            'duration_days' => ['required', 'integer', 'in:7,15,30,60'],
            'coupon_code' => ['nullable', 'string'],
        ]);

        $job = Job::findOrFail($id);
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        PaymentService::processFeaturedJobPromotion(Auth::user(), $job, $request->duration_days, $request->coupon_code);

        return redirect()->route('employer.jobs.index')->with('success', 'Job promoted successfully.');
    }

    // Seeker Profile Boost Dashboard
    public function seekerBoost()
    {
        $user = Auth::user();
        $boost = $user->activeResumeBoost;
        $history = Payment::where('user_id', $user->id)
            ->where('payment_type', 'resume_boost')
            ->latest()
            ->get();

        return view('seeker.boost', compact('boost', 'history'));
    }

    // Process Seeker Profile Boost payment
    public function boostProfile(Request $request)
    {
        $request->validate([
            'duration_days' => ['required', 'integer', 'in:7,15,30'],
            'coupon_code' => ['nullable', 'string'],
        ]);

        PaymentService::processResumeBoost(Auth::user(), $request->duration_days, $request->coupon_code);

        return redirect()->route('seeker.boost.index')->with('success', 'Profile boost activated successfully.');
    }

    // View Invoice Receipt HTML/Details
    public function showInvoice($invoiceNumber)
    {
        $invoice = Invoice::where('invoice_number', $invoiceNumber)->firstOrFail();
        $payment = $invoice->payment;

        // Secure Invoice (only admin or paying user can view)
        if (Auth::user()->role !== 'admin' && $payment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('employer.invoice', compact('invoice', 'payment'));
    }
}
