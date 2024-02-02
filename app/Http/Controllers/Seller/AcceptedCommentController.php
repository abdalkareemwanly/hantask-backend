<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcceptedCommentController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Comment::whereHas('post')->whereHas('seller')
                ->where('comment','like', '%' . $request->search . '%')
                ->whereRelation('seller','id',Auth::user()->id)->where('status','1')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                   'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'work_status'        => $row->workStatus,
                    'buyer_id'           => $row->post->buyer->id,
                    'buyer_name'         => $row->post->buyer->name,
                    'buyer_email'        => $row->post->buyer->email,
                    'buyer_phone'        => $row->post->buyer->phone,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_dead_line'     => $row->post->dead_line,
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
                ->whereRelation('seller','id',Auth::user()->id)->where('status','1')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'work_status'        => $row->workStatus,
                    'buyer_id'           => $row->post->buyer->id,
                    'buyer_name'         => $row->post->buyer->name,
                    'buyer_email'        => $row->post->buyer->email,
                    'buyer_phone'        => $row->post->buyer->phone,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_dead_line'     => $row->post->dead_line,
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
                ->whereRelation('seller','id',Auth::user()->id)->where('status','1')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'work_status'        => $row->workStatus,
                    'buyer_id'           => $row->post->buyer->id,
                    'buyer_name'         => $row->post->buyer->name,
                    'buyer_email'        => $row->post->buyer->email,
                    'buyer_phone'        => $row->post->buyer->phone,
                    'post_title'         => $row->post->title,
                    'post_description'   => $row->post->description,
                    'post_budget'        => $row->post->budget,
                    'post_dead_line'     => $row->post->dead_line,
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
}
