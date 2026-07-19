<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'type' => ['required', 'string', 'in:percentage,fixed'],
            'value' => ['required', 'integer', 'min:1'],
            'starts_at' => ['required', 'date'],
            'expires_at' => ['nullable', 'date', 'after:starts_at'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
        ]);

        $coupon = Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
            'usage_limit' => $request->usage_limit,
            'status' => 'active',
        ]);

        AuditLogHelper::log(Auth::id(), 'coupon_created', "Created discount coupon: {$coupon->code}");

        return redirect()->back()->with('success', 'Coupon created successfully.');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $newStatus = $coupon->status === 'active' ? 'inactive' : 'active';
        $coupon->update(['status' => $newStatus]);

        AuditLogHelper::log(Auth::id(), 'coupon_status_toggled', "Toggled status of coupon ID {$coupon->id} to {$newStatus}");

        return redirect()->back()->with('success', "Coupon status updated to {$newStatus}.");
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $code = $coupon->code;
        $coupon->delete();

        AuditLogHelper::log(Auth::id(), 'coupon_deleted', "Deleted coupon: {$code}");

        return redirect()->back()->with('success', 'Coupon deleted.');
    }
}
