<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Payout;
use Stripe\Stripe;

class PayoutHistoryController extends Controller
{
    public function index()
    {
        $data = [];
        $user_id = Auth::user()->id;

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $payouts = Payout::all();

        foreach ($payouts as $payout) {
            if ($payout->user_id == $user_id) {
                $data[] = [
                    'id' => $payout->id,
                    'amount' => $payout->amount,
                    'status' => $payout->status,
                    'paid_at' => $payout->paid_at,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'mes' => 'User Payment History',
            'data' => $data
        ]);
    }
}
