<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\comment\StatuseRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Comment;
use App\Models\Review;
use App\Models\NotificationSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class AcceptedCommentController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Comment::whereHas('post')->whereHas('seller')
            ->where('comment','like', '%' . $request->search . '%')
            ->whereRelation('post','buyer_id',Auth::user()->id)->where('status','1')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $data_review = [];
                $review = Review::where('comment_id',$row->id)->where('sender_id',Auth::user()->id)->first();
                if(isset($review)) {
                    $data_review[] = [
                        'id'          => $review->id,
                        'review'      => $review->review,
                        'description' => $review->description,
                    ];
                } else {
                    $data_review = false;
                }
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'work_status'        => $row->workStatus,
                    'seller_id'          => $row->seller->id,
                    'seller_name'        => $row->seller->name,
                    'seller_email'       => $row->seller->email,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_deadLine'      => $row->post->dead_line,
                    'post_image'         => '/uploads/images/posts/'.$row->post->image,
                    'data_review'        => $data_review
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
            $paginate = Comment::whereHas('post')->whereHas('seller')
                ->where('comment','like', '%' . $request->search . '%')
                ->whereRelation('post','buyer_id',Auth::user()->id)->where('status','1')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $data_review = [];
                $review = Review::where('comment_id',$row->id)->where('sender_id',Auth::user()->id)->first();
                if(isset($review)) {
                    $data_review[] = [
                        'id'          => $review->id,
                        'review'      => $review->review,
                        'description' => $review->description,
                    ];
                } else {
                    $data_review = false;
                }
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'work_status'        => $row->workStatus,
                    'seller_id'          => $row->seller->id,
                    'seller_name'        => $row->seller->name,
                    'seller_email'       => $row->seller->email,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_deadLine'      => $row->post->dead_line,
                    'post_image'         => '/uploads/images/posts/'.$row->post->image,
                    'data_review'        => $data_review
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
            $paginate = Comment::whereHas('post')->whereHas('seller')
            ->where('comment','like', '%' . $request->search . '%')
            ->whereRelation('post','buyer_id',Auth::user()->id)->where('status','1')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $data_review = [];
                $review = Review::where('comment_id',$row->id)->where('sender_id',Auth::user()->id)->first();
                if(isset($review)) {
                    $data_review[] = [
                        'id'          => $review->id,
                        'review'      => $review->review,
                        'description' => $review->description,
                    ];
                } else {
                    $data_review = false;
                }
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'work_status'        => $row->workStatus,
                    'seller_id'          => $row->seller->id,
                    'seller_name'        => $row->seller->name,
                    'seller_email'       => $row->seller->email,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_deadLine'      => $row->post->dead_line,
                    'post_image'         => '/uploads/images/posts/'.$row->post->image,
                    'data_review'        => $data_review
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

    public function workStatus(StatuseRequest $request , $id)
    {
        $pusherConfig = config('broadcasting.connections.pusher');
         $options = [
            'cluster' => $pusherConfig['options']['cluster'],
            'encrypted' => $pusherConfig['options']['encrypted'],
        ];

    $pusher = new Pusher(
        $pusherConfig['key'],
        $pusherConfig['secret'],
        $pusherConfig['app_id'],
        $options
    );
        $data = $request->validated();
        $record = Comment::whereHas('seller')->whereHas('post')->where('id',$id)->first();
        if($data['workStatus'] == 2) {
            $update = $record->update([
                'workStatus' => '2',
            ]);
            $message = 'The comment ' .$record->comment. ' has been progress';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'comment progress Successfully',
            ]);
        } elseif ($data['workStatus'] == 3) {
            $update = $record->update([
                'workStatus' => '3',
            ]);
            $message = 'The comment ' .$record->comment. ' has been completed';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'comment completed Successfully',
            ]);
        }elseif ($data['workStatus'] == 4) {
            $update = $record->update([
                'workStatus' => '4',
            ]);
            $message = 'The comment ' .$record->comment. ' has been cancelled';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'comment cancelled Successfully',
            ]);
        }
    }
}
