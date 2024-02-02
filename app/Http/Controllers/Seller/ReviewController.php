<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Review\StoreRequest;
use App\Http\Requests\Buyer\Review\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Review::whereHas('comment')
            ->where('review','like', '%' . $request->search . '%')
            ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $review_from = [];
                $review_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $review_to = [
                        'name'  => $row->comment->post->buyer->name,
                        'email' => $row->comment->post->buyer->email,
                        'phone' => $row->comment->post->buyer->phone,
                    ];
                    $review_from = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $review_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $review_from = [
                        'name'  => $row->comment->post->buyer->name,
                        'email' => $row->comment->post->buyer->email,
                        'phone' => $row->comment->post->buyer->phone,
                    ];

                }

                return [
                    'id' => $row->id,
                    'review' => $row->review,
                    'created_at' => $row->created_at,
                    'comment_id' => $row->comment->id,
                    'review_to' => $review_to,
                    'review_from' => $review_from
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
            $paginate = Review::whereHas('comment')
            ->where('review','like', '%' . $request->search . '%')
            ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $review_from = [];
                $review_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $review_to = [
                        'name'  => $row->comment->post->buyer->name,
                        'email' => $row->comment->post->buyer->email,
                        'phone' => $row->comment->post->buyer->phone,
                    ];
                    $review_from = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $review_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $review_from = [

                        'name'  => $row->comment->post->buyer->name,
                        'email' => $row->comment->post->buyer->email,
                        'phone' => $row->comment->post->buyer->phone,
                    ];

                }

                return [
                    'id' => $row->id,
                    'review' => $row->review,
                    'created_at' => $row->created_at,
                    'comment_id' => $row->comment->id,
                    'review_to' => $review_to,
                    'review_from' => $review_from
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
            $paginate = Review::whereHas('comment')
            ->where('review','like', '%' . $request->search . '%')
            ->where('sender_id',Auth::user()->id)->orWhere('recipient_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $review_from = [];
                $review_to = [];
                if($row->sender_id == Auth::user()->id) {
                    $review_to = [
                        'name'  => $row->comment->post->buyer->name,
                        'email' => $row->comment->post->buyer->email,
                        'phone' => $row->comment->post->buyer->phone,
                    ];
                    $review_from = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                } elseif($row->recipient_id == Auth::user()->id) {
                    $review_to = [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ];
                    $review_from = [

                        'name'  => $row->comment->post->buyer->name,
                        'email' => $row->comment->post->buyer->email,
                        'phone' => $row->comment->post->buyer->phone,
                    ];

                }

                return [
                    'id' => $row->id,
                    'review' => $row->review,
                    'created_at' => $row->created_at,
                    'comment_id' => $row->comment->id,
                    'review_to' => $review_to,
                    'review_from' => $review_from
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
        $data['sender_id'] = Auth::user()->id;
        Review::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Review Successfully',
        ]);
    }
    public function update(UpdateRequest $request , $id)
    {
        $record = Review::find($id);
        $record->update([
            'recipient_id'    => $request->recipient_id ?? $record->recipient_id,
            'comment_id'      => $request->comment_id ?? $record->comment_id,
            'review'          => $request->review ?? $record->review,
            'description'     => $request->description ?? $record->description,
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

