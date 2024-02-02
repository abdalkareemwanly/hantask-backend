<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Subscription\Coupon\SearchRequest;
use App\Http\Requests\Subscription\Coupon\storeRequest;
use App\Http\Requests\Subscription\Coupon\updateRequest;
use App\Models\subscription_coupon;
use Illuminate\Http\Request;
use Stripe\Coupon;
use Stripe\Stripe;

class SubscriptionCouponController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = subscription_coupon::whereHas('plan')->where('name','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'name' => $coupon->name,
                    'amount' => $coupon->amount,
                    'currency' => $coupon->currency,
                    'plan_id' => $coupon->plan->id,
                    'status' => $coupon->status,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        }
        if($request->paginate) {
            $paginate = subscription_coupon::whereHas('plan')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'name' => $coupon->name,
                    'amount' => $coupon->amount,
                    'currency' => $coupon->currency,
                    'plan_id' => $coupon->plan->id,
                    'status' => $coupon->status,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        } else {
            $paginate = subscription_coupon::whereHas('plan')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'name' => $coupon->name,
                    'amount' => $coupon->amount,
                    'currency' => $coupon->currency,
                    'plan_id' => $coupon->plan->id,
                    'status' => $coupon->status,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        }
    }
    public function store(storeRequest $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $amount_off = ($request->amount_off * 100);
        $coupon = Coupon::create([
            'name' => $request->name,
            'amount_off' => $request->amount_off,
            'currency' => 'usd',
        ]);
        subscription_coupon::create([
            'coupon_id' => $coupon->id,
            'name' => $coupon->name,
            'amount' => $coupon->amount_off,
            'plan_id' => $request->plan_id,
            'currency' => 'usd',
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Store subscriptionCoupon Successfully',
        ]);
    }
    public function status($id)
    {
        $record = subscription_coupon::find($id);
        if($record->status == 1) {
            $update = subscription_coupon::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = subscription_coupon::where('id',$id)->update([
                'status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Completed Successfully',
            ]);
        }
    }
    public function update(updateRequest $request , $id)
    {
        $record = subscription_coupon::find($id);
        $record->update([
            'code'              => $request->code ?? $record->code,
            'discount'          => $request->discount ?? $record->discount,
            'discount_type'     => $request->discount_type ?? $record->discount_type,
            'expire_date'       => $request->expire_date ?? $record->expire_date,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update subscriptionCoupon Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = subscription_coupon::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete subscriptionCoupon Successfully',
        ]);
    }
}
