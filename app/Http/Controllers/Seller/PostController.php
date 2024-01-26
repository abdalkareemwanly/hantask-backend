<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Seller\Comment\storeRequest;
use App\Http\Requests\Seller\Comment\updateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Post::whereHas('buyer')
                ->where('title','like', '%' . $request->search . '%');
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'buyer name'    => $row->buyer->name,
                    'title'         => $row->title,
                    'description'   => $row->description,
                    'image'         => '/uploads/images/posts/'.$row->image,
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
            $paginate = Post::whereHas('buyer')
                ->where('title','like', '%' . $request->search . '%')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'buyer name'    => $row->buyer->name,
                    'title'         => $row->title,
                    'description'   => $row->description,
                    'image'         => '/uploads/images/posts/'.$row->image,
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
            $paginate = Post::whereHas('buyer')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'buyer name'    => $row->buyer->name,
                    'title'         => $row->title,
                    'description'   => $row->description,
                    'image'         => '/uploads/images/posts/'.$row->image,
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
    public function comments($id)
    {
        $paginate = Comment::whereHas('seller')->whereHas('post')
                ->where('seller_id',Auth::user()->id)->where('post_id',$id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'seller name'   => $row->seller->name,
                    'post name'     => $row->post->title,
                    'comment'       => $row->comment,
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
    public function storeComment(storeRequest $request ,$id)
    {
        $data = $request->validated();
        Comment::create([
            'comment'    => $data['comment'],
            'budget'     => $data['budget'],
            'dead_line'  => $data['dead_line'],
            'post_id'    => $id,
            'seller_id'  => Auth::user()->id
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Comment Store Successfully',
        ]);
    }
    public function updateComment(updateRequest $request , $id)
    {
        $record = Comment::find($id);
        $record->update([
            'comment'   => $request->comment ?? $record->comment,
            'budget'    => $request->budget ?? $record->budget,
            'dead_line' => $request->dead_line ?? $record->dead_line,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Comment Successfully',
        ]);
    }
    public function deleteComment($id)
    {
        $record = Comment::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Comment Successfully',
        ]);
    }
    public function report()
    {
        $data = [];
        $reports = Report::where('seller_id',Auth::user()->id)->get();
        foreach($reports as $report) {
            $data [] = [
                'id'     => $report->id,
                'report' => $report->report,
            ];
        }
        return response()->json([
            'success' => true,
            'mes'     => 'All Reports',
            'data'    => $data
        ]);
    }
}
