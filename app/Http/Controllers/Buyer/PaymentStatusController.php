<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\PaymentStatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentStatusController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = PaymentStatu::whereHas('seller')
                ->where('payment','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'payment'            => $row->payment,
                    'status'             => $row->status,
                    'seller name'        => $row->seller->name,
                    'seller email'       => $row->seller->email,
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
            $paginate = PaymentStatu::whereHas('seller')
                ->where('payment','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'status'             => $row->status,
                    'seller name'        => $row->seller->name,
                    'seller email'       => $row->seller->email,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
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
            $paginate = PaymentStatu::whereHas('seller')
                ->where('payment','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'status'             => $row->status,
                    'seller name'        => $row->seller->name,
                    'seller email'       => $row->seller->email,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
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
    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required',
            'payment'   => 'required',
        ]);
        PaymentStatu::create([
            'buyer_id'  => Auth::user()->id,
            'seller_id' => $request->seller_id,
            'payment'   => $request->payment,
        ]);
        return response()->json([
            'success' => true,
            'mes'     => 'Store Payment Successfully'
        ]);
    }
}
