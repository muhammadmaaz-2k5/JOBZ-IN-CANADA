<?php

namespace App\Services;

use App\Models\User;
use App\Models\Job;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Coupon;
use App\Models\FeaturedJob;
use App\Models\ResumeBoost;
use App\Models\Notification;
use App\Helpers\AuditLogHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    public static function processSubscription(User $user, SubscriptionPlan $plan, $billingCycle = 'monthly', $couponCode = null)
    {
        return DB::transaction(function () use ($user, $plan, $billingCycle, $couponCode) {
            $basePrice = $billingCycle === 'yearly' ? $plan->yearly_price : $plan->monthly_price;
            $discount = 0;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->where('status', 'active')->first();
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($basePrice);
                }
            }

            $subtotal = $basePrice;
            $tax = round(($subtotal - $discount) * 0.13); // 13% tax HST
            $total = ($subtotal - $discount) + $tax;

            // 1. Log Payment
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $total,
                'currency' => 'CAD',
                'payment_gateway' => 'mock',
                'transaction_id' => 'sub_' . Str::random(16),
                'payment_type' => 'subscription',
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // 2. Log Invoice
            Invoice::create([
                'payment_id' => $payment->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'invoice_url' => null,
            ]);

            // 3. Deactivate any existing active subscriptions
            Subscription::where('employer_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired', 'ends_at' => now()]);

            // 4. Create new Subscription
            $durationMonths = $billingCycle === 'yearly' ? 12 : 1;
            $subscription = Subscription::create([
                'employer_id' => $user->id,
                'plan_id' => $plan->id,
                'gateway_subscription_id' => $payment->transaction_id,
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonths($durationMonths),
                'renews_at' => now()->addMonths($durationMonths),
            ]);

            // 5. Send notifications
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Subscription Activated',
                'body' => "You have successfully subscribed to the {$plan->name} ({$billingCycle} billing).",
                'type' => 'billing',
                'data' => [
                    'plan_name' => $plan->name,
                    'total_paid' => $total
                ],
                'is_read' => false,
            ]);

            AuditLogHelper::log($user->id, 'subscription_created', "Subscribed to plan ID {$plan->id} ({$billingCycle})");

            return $subscription;
        });
    }

    public static function processFeaturedJobPromotion(User $user, Job $job, $durationDays, $couponCode = null)
    {
        return DB::transaction(function () use ($user, $job, $durationDays, $couponCode) {
            // Pricing: 7 days => $10, 15 days => $18, 30 days => $30, 60 days => $50
            $priceMap = [
                7 => 10,
                15 => 18,
                30 => 30,
                60 => 50
            ];
            $basePrice = $priceMap[$durationDays] ?? 30;
            $discount = 0;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->where('status', 'active')->first();
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($basePrice);
                }
            }

            $subtotal = $basePrice;
            $tax = round(($subtotal - $discount) * 0.13);
            $total = ($subtotal - $discount) + $tax;

            // 1. Log Payment
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $total,
                'currency' => 'CAD',
                'payment_gateway' => 'mock',
                'transaction_id' => 'feat_' . Str::random(16),
                'payment_type' => 'featured_job',
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // 2. Log Invoice
            Invoice::create([
                'payment_id' => $payment->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'invoice_url' => null,
            ]);

            // 3. Create FeaturedJob promotion
            FeaturedJob::create([
                'job_id' => $job->id,
                'employer_id' => $user->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($durationDays),
                'payment_id' => $payment->id,
            ]);

            // 4. Update Job featured flag to true
            $job->update([
                'featured' => true,
            ]);

            // 5. Notification
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Job Promoted to Featured',
                'body' => "Your job listing \"{$job->title}\" has been promoted to Featured for {$durationDays} days.",
                'type' => 'billing',
                'data' => [
                    'job_id' => $job->id,
                    'duration' => $durationDays
                ],
                'is_read' => false,
            ]);

            AuditLogHelper::log($user->id, 'job_featured_promotion', "Promoted Job ID {$job->id} to featured for {$durationDays} days");

            return $payment;
        });
    }

    public static function processResumeBoost(User $user, $durationDays, $couponCode = null)
    {
        return DB::transaction(function () use ($user, $durationDays, $couponCode) {
            // Pricing: 7 days => $5, 15 days => $9, 30 days => $15
            $priceMap = [
                7 => 5,
                15 => 9,
                30 => 15
            ];
            $basePrice = $priceMap[$durationDays] ?? 15;
            $discount = 0;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->where('status', 'active')->first();
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($basePrice);
                }
            }

            $subtotal = $basePrice;
            $tax = round(($subtotal - $discount) * 0.13);
            $total = ($subtotal - $discount) + $tax;

            // 1. Log Payment
            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $total,
                'currency' => 'CAD',
                'payment_gateway' => 'mock',
                'transaction_id' => 'bst_' . Str::random(16),
                'payment_type' => 'resume_boost',
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // 2. Log Invoice
            Invoice::create([
                'payment_id' => $payment->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'invoice_url' => null,
            ]);

            // 3. Create ResumeBoost
            ResumeBoost::create([
                'user_id' => $user->id,
                'starts_at' => now(),
                'expires_at' => now()->addDays($durationDays),
                'payment_id' => $payment->id,
            ]);

            // 4. Notification
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Resume Profile Boost Activated',
                'body' => "Your profile visibility boost has been activated for {$durationDays} days.",
                'type' => 'billing',
                'data' => [
                    'duration' => $durationDays
                ],
                'is_read' => false,
            ]);

            AuditLogHelper::log($user->id, 'resume_profile_boosted', "Boosted Resume Profile for {$durationDays} days");

            return $payment;
        });
    }
}
