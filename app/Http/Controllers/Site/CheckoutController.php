<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CheckoutRequest;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $user->createOrGetStripeCustomer();
        $paymentMethod = $request->payment_method;
        if($paymentMethod != null) {
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
        }
        $plan = $request->plan_id;
        $paymentId = $request->payment_id;
        try {
            $user->newSubscription(
                'default',$plan
            )->create($paymentMethod != null ? $paymentMethod->id : '');
            $user->payment_id= $paymentId;
            $user->save();
            return response()->json([
                'message' => 'Payment completed successfully'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Error' . $e->getMessage()
            ]);
        }
    }
}
