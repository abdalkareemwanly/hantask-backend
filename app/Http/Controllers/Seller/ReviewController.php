<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Review::whereHas('buyer')->whereHas('service')
                    ->where('review','like', '%' . $request->search . '%')
                    ->where('seller_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                  => $row->id,
                    'buyer name'          => $row->buyer->name,
                    'buyer email'         => $row->buyer->email,
                    'service title'       => $row->service->title,
                    'service slug'        => $row->service->slug,
                    'service description' => $row->service->description,
                    'service image'       => '/uploads/images/services/'.$row->service->image,
                    'review'              => $row->review,
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
                    ->where('seller_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                  => $row->id,
                    'buyer name'          => $row->buyer->name,
                    'buyer email'         => $row->buyer->email,
                    'service title'       => $row->service->title,
                    'service slug'        => $row->service->slug,
                    'service description' => $row->service->description,
                    'service image'       => '/uploads/images/services/'.$row->service->image,
                    'review'              => $row->review,
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
            $paginate = Review::whereHas('buyer')->whereHas('service')->where('seller_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                  => $row->id,
                    'buyer name'          => $row->buyer->name,
                    'buyer email'         => $row->buyer->email,
                    'service title'       => $row->service->title,
                    'service slug'        => $row->service->slug,
                    'service description' => $row->service->description,
                    'service image'       => '/uploads/images/services/'.$row->service->image,
                    'review'              => $row->review,
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

}
