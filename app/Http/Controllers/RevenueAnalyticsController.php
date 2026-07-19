<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueAnalyticsController extends Controller
{
    public function index()
    {
        // Monthly Revenue (last 30 days)
        $monthlyRevenue = Payment::where('status', 'paid')
            ->where('paid_at', '>=', now()->subDays(30))
            ->sum('amount');

        // Annual Revenue (last 365 days)
        $annualRevenue = Payment::where('status', 'paid')
            ->where('paid_at', '>=', now()->subDays(365))
            ->sum('amount');

        // Active Subscriptions
        $activeSubscriptionsCount = Subscription::where('status', 'active')->count();

        // Churn Rate
        $cancelledCount = Subscription::where('status', 'cancelled')->count();
        $totalSubscriptions = Subscription::count();
        $churnRate = $totalSubscriptions > 0 ? round(($cancelledCount / $totalSubscriptions) * 100, 1) : 0;

        // Featured Job Sales
        $featuredJobSales = Payment::where('payment_type', 'featured_job')
            ->where('status', 'paid')
            ->sum('amount');

        // Resume Boost Sales
        $resumeBoostSales = Payment::where('payment_type', 'resume_boost')
            ->where('status', 'paid')
            ->sum('amount');

        // Subscriptions Revenue
        $subscriptionSales = Payment::where('payment_type', 'subscription')
            ->where('status', 'paid')
            ->sum('amount');

        // Transactions list
        $transactions = Payment::with('user')->latest()->paginate(15);

        return view('admin.revenue_analytics', compact(
            'monthlyRevenue',
            'annualRevenue',
            'activeSubscriptionsCount',
            'churnRate',
            'featuredJobSales',
            'resumeBoostSales',
            'subscriptionSales',
            'transactions'
        ));
    }
}
