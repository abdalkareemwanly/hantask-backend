<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Comment::whereHas('post')->whereHas('seller')
                ->where('comment','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'status'             => $row->status,
                    'seller name'        => $row->seller->name,
                    'seller email'       => $row->seller->email,
                    'buyer name'         => $row->post->buyer->name,
                    'buyer email'        => $row->post->buyer->email,
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
                ->where('comment','like', '%' . $request->search . '%')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'status'             => $row->status,
                    'seller name'        => $row->seller->name,
                    'seller email'       => $row->seller->email,
                    'buyer name'         => $row->post->buyer->name,
                    'buyer email'        => $row->post->buyer->email,
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
                ->where('comment','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'comment'            => $row->comment,
                    'status'             => $row->status,
                    'seller name'        => $row->seller->name,
                    'seller email'       => $row->seller->email,
                    'buyer name'         => $row->post->buyer->name,
                    'buyer email'        => $row->post->buyer->email,
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
    public function delete($id)
    {
        $record = Comment::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes'     => 'Delete Comment Successfully'
        ]);
    }
}
