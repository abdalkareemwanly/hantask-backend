<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Subscription\Coupon\SearchRequest;
use App\Http\Requests\Subscription\Coupon\storeRequest;
use App\Http\Requests\Subscription\Coupon\updateRequest;
use App\Models\subscription_coupon;
use Illuminate\Http\Request;

class SubscriptionCouponController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $info = [];
            $search = subscription_coupon::where('code',$request->search)->get();
            foreach($search as $row) {
                    $info[] = [
                        'id' => $row->id,
                        'code' => $row->code,
                        'discount' => $row->discount,
                        'discount_type' => $row->discount_type,
                        'expire_date' => $row->expire_date,
                        'status' => $row->status,
                    ];
            }
            if($search) {
                return response()->json([
                    'success' => true,
                    'message' => 'Search subscriptionCoupon Successfully',
                    'searchResult' => $info,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Search subscriptionCoupon Error',
                ]);
            }
        }
        if($request->paginate) {
            $paginate = subscription_coupon::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'discount' => $coupon->discount,
                    'discount_type' => $coupon->discount_type,
                    'expire_date' => $coupon->expire_date,
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
            $paginate = subscription_coupon::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'discount' => $coupon->discount,
                    'discount_type' => $coupon->discount_type,
                    'expire_date' => $coupon->expire_date,
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
