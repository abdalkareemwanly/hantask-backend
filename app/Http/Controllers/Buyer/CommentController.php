<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\comment\StatuseRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Comment;
use App\Models\NotificationSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class CommentController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Comment::whereHas('post')->whereHas('seller')
                ->where('comment','like', '%' . $request->search . '%')
                ->whereRelation('post','buyer_id',Auth::user()->id)->where('status','0')->orWhere('status','2')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
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
                    'seller_phone'       => $row->seller->phone,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_deadLine'      => $row->post->dead_line,
                    'post_image'         => '/uploads/images/posts/'.$row->post->image,
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
                ->whereRelation('post','buyer_id',Auth::user()->id)->where('status','0')->orWhere('status','2')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
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
                    'seller_phone'       => $row->seller->phone,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_deadLine'      => $row->post->dead_line,
                    'post_image'         => '/uploads/images/posts/'.$row->post->image,
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
                ->whereRelation('post','buyer_id',Auth::user()->id)->where('status','0')->orWhere('status','2')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
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
                    'seller_phone'       => $row->seller->phone,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_deadLine'      => $row->post->dead_line,
                    'post_image'         => '/uploads/images/posts/'.$row->post->image,
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
     public function status(StatuseRequest $request , $id)
     {
        /*$pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER')]
        );*/
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


        $record = Comment::find($id);
        if($request->status == 1) {
            $update = $record->update([
                'status'     => '1',
                'workStatus' => '1',
            ]);
            $message = 'The comment ' .$record->comment. ' has been being processed';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'comment is being processed Successfully',
            ]);
        } elseif ($request->status == 2) {
            $update = $record->update([
                'status'     => '2',
                'workStatus' => null,
            ]);
            $message = 'The comment ' .$record->comment. ' has been unaccepted';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'comment unaccepted Successfully',
            ]);
        }

    }
}
