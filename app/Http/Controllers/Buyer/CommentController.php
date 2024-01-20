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
                ->whereRelation('post','buyer_id',Auth::user()->id)->paginate(10);
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
        if($request->paginate) {
            $paginate = Comment::whereHas('post')->whereHas('seller')
                ->where('comment','like', '%' . $request->search . '%')
                ->whereRelation('post','buyer_id',Auth::user()->id)->paginate($request->paginate);
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
            $paginate = Comment::whereHas('post')->whereHas('seller')
                ->where('comment','like', '%' . $request->search . '%')
                ->whereRelation('post','buyer_id',Auth::user()->id)->paginate(10);
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
    public function status(StatuseRequest $request , $id)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER')]
        );
        $data = $request->validated();
        $record = Comment::whereHas('seller')->whereHas('post')->where('id',$id)->first();
        if($data['status'] == 1) {
            $update = $record->update([
                'status' => '1',
            ]);
            $message = 'The comment ' .$record->comment. ' has been accepted';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Update Status Successfully',
            ]);
        } elseif($data['status'] == 2) {
            $update = $record->update([
                'status' => '2',
            ]);
            $message = 'The comment ' .$record->comment. ' has been under construction';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Update Status Successfully',
            ]);
        } elseif($data['status'] == 3) {
            $update = $record->update([
                'status' => '3',
            ]);
            $message = 'The comment ' .$record->comment. ' has been completed';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Update Status Successfully',
            ]);
        } elseif($data['status'] == 4) {
            $update = $record->update([
                'status' => '4',
            ]);
            $message = 'The comment ' .$record->comment. ' has been canceled';
            $pusher->trigger('hantask', 'pushNotificationEvent', ['message' => $message],['persisted' => true , 'where' => ['seller_id' => $record->seller_id,],]);
            NotificationSeller::create([
                'seller_id' => $record->seller_id,
                'title' => $message,
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Update Status Successfully',
            ]);
        }
    }
}
