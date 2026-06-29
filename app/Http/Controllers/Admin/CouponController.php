<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private function isAdmin()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('Dashboard.Pages.Coupons.index',compact('coupons'));
    }

    public function create()
    {
        abort_if(!$this->isAdmin(), 403);
        return view('Dashboard.Pages.Coupons.create');
    }

    public function store(Request $request)
    {
        abort_if(!$this->isAdmin(), 403);
        $data = $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['used_count'] = 0;

        $coupons = Coupon::create($data);

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'coupon',
            'New coupon name Created',
            "category {$coupons->code} was created"
        );

        return redirect()->route('coupons.index')->with('success', __('messages.flash_coupon_created'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Coupon $coupon)
    {
        abort_if(!$this->isAdmin(), 403);
        return view('Dashboard.Pages.Coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        abort_if(!$this->isAdmin(), 403);
        $data = $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $coupon->update($data);

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'coupon',
            'New coupon name Updated',
            "category {$coupon->code} was updated"
        );

        return redirect()->route('coupons.index')->with('updated', __('messages.flash_coupon_updated'));
    }

    public function destroy(Coupon $coupon)
    {
        abort_if(!$this->isAdmin(), 403);
        $coupon->delete();

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'coupon',
            'New coupon name deleted',
            "category {$coupon->code} was deleted"
        );

        return redirect()->route('coupons.index')->with('deleted', __('messages.flash_coupon_deleted'));
    }

    public function toggle(Coupon $coupon)
    {
        abort_if(!auth()->check(), 403);

        if (!in_array(auth()->user()->role, ['admin', 'employee'])) {
            abort(403);
        }

        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return back()->with('success', __('messages.flash_coupon_status_updated'));
    }
}
