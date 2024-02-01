<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Payout;
use Stripe\Stripe;
use Exception;
class PayoutHistoryController extends Controller
{
    public function index()
    {
        $data = [];
        $user_id = Auth::user()->id;

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Use the 'destination' parameter instead of 'payout_method'
            $payouts = Payout::all(['limit' => 100, 'destination' => $user_id]);

            foreach ($payouts->data as $payout) {
                $data[] = [
                    'id' => $payout->id,
                    'amount' => $payout->amount,
                    'status' => $payout->status,
                    'paid_at' => $payout->arrival_date,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'User Payment History',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving payment history: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
