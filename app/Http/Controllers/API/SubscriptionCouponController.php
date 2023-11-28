<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Subscription\Coupon\storeRequest;
use App\Http\Requests\Subscription\Coupon\updateRequest;
use App\Models\subscription_coupon;
use Illuminate\Http\Request;

class SubscriptionCouponController extends Controller
{
    public function index(PaginatRequest $request)
    {
        $data = [];
        $paginate = $request->validated();
        if(!$paginate) {
            $subscription_coupon = subscription_coupon::paginate(10);
            foreach($subscription_coupon as $coupon) {
                $data[] = [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'discount' => $coupon->discount,
                    'discount_type' => $coupon->discount_type,
                    'expire_date' => $coupon->expire_date,
                    'status' => $coupon->status,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All subscriptionCoupons',
                'data' => $data
            ]);
        } else {
            $subscription_coupon = subscription_coupon::paginate($paginate);
            foreach($subscription_coupon as $coupon) {
                $data[] = [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'discount' => $coupon->discount,
                    'discount_type' => $coupon->discount_type,
                    'expire_date' => $coupon->expire_date,
                    'status' => $coupon->status,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All subscriptionCoupons',
                'data' => $data
            ]);
        }

    }
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        subscription_coupon::create($data);
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
