<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Review\StoreRequest;
use App\Http\Requests\Buyer\Review\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Review::whereHas('buyer')->whereHas('service')
                    ->where('review','like', '%' . $request->search . '%')
                    ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'seller name' => $row->service->seller->name,
                    'seller email' => $row->service->seller->email,
                    'service title' => $row->service->title,
                    'review' => $row->review,
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
            $paginate = Review::whereHas('buyer')->whereHas('service')
                    ->where('review','like', '%' . $request->search . '%')
                    ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'seller name' => $row->service->seller->name,
                    'seller email' => $row->service->seller->email,
                    'service title' => $row->service->title,
                    'review' => $row->review,
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
            $paginate = Review::whereHas('buyer')->whereHas('service')->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'seller name' => $row->service->seller->name,
                    'seller email' => $row->service->seller->email,
                    'service title' => $row->service->title,
                    'review' => $row->review,
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
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $seller_id = Service::where('id',$data['service_id'])->first();
        $data['buyer_id'] = Auth::user()->id;
        $data['seller_id'] = $seller_id->seller_id;
        Review::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Review Successfully',
        ]);
    }
    public function update(UpdateRequest $request , $id)
    {
        $seller = Service::whereHas('seller')->where('id',$request->service_id)->first();
        $record = Review::find($id);
        $record->update([
            'service_id'      => $request->service_id ?? $record->service_id,
            'seller_id'       => $seller->seller->id ?? $record->seller_id,
            'review'          => $request->review ?? $record->review,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Review Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Review::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Review Successfully',
        ]);
    }
}
