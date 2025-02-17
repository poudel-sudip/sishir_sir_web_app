<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\BookingCoupon as Coupon;

class BookingCouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function generateCouponCode()
    {
        $firstPart = Str::random(3);
        $secondPart = Str::random(3);
        return strtolower($firstPart) . '-' . strtolower($secondPart);
    }

    public function usedCoupons()
    {
        $data = [];
        $data['coupons'] = Coupon::where('used','=',true)->orderByDesc('use_date')->paginate(100);
        return view('admin.coupon.used',$data);
    }

    public function index()
    {
        $data = [];
        $data['coupons'] = Coupon::where('used','=',false)->orderByDesc('id')->get();
        return view('admin.coupon.index',$data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'coupon_for' => 'required|string',
            'coupon_count' => 'required|numeric|gt:0',
        ]);

        $types = ['exam','pdfbank'];
        if(!in_array(strtolower(trim($request->coupon_for)),$types))
        {
            return back()->withInput()->withErrors(['coupon_for'=>'Invalid Coupon Type.']);
        }

        for ($i=0; $i < $request->coupon_count; $i++) 
        { 
            do {
                $c_code = strtolower(trim($request->coupon_for)).'-'.$this->generateCouponCode();
            } 
            while (Coupon::where('coupon', $c_code)->exists());

            Coupon::create([
                'source' => strtolower(trim($request->coupon_for)),
                'coupon' => $c_code,
                'used' => false,
            ]);
        }

        return redirect('/admin/booking-coupons');
    }

    public function destroy(Coupon $coupon, Request $request)
    {
        $coupon->delete();
        return redirect('/admin/booking-coupons');
    }

}
