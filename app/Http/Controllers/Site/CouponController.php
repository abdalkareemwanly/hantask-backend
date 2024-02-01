<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;

class CouponController extends Controller
{
    public function payCoupon(Request $request)
    {
        $user = $request->user();
        $coupon = $request->coupon;

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not found',
            ], 400);
        }
        
        try {
                if (isset($coupon->amount) && isset($coupon->currency)) {
                $charge = $user->charge($coupon->amount, $coupon->currency, [
                    'description' => 'Coupon payment',
                ]);

                if ($charge->paid) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Coupon payment successful',
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $charge->failure_message,
                    ], 400);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
