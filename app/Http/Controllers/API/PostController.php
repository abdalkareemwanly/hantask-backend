<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $info = [];
            $search = Post::whereHas('customer')->where('title',$request->search)->orWhere('description',$request->search)->get();
            foreach($search as $row) {
                $imagePath = '/uploads/images/posts';
                $info[] = [
                    'id' => $row->id,
                    'customerName' => $row->customer->name,
                    'title' => $row->title,
                    'description' => $row->description,
                    'short description' => $row->short_description,
                    'image' => $imagePath .'/',$row->image,
                    'status' => $row->status,
                ];
            }
            if($search) {
                return response()->json([
                    'success' => true,
                    'message' => 'Search Country Successfully',
                    'searchResult' => $info,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Search Country Error',
                ]);
            }
        }
        if($request->paginate) {
            $paginate =  Post::whereHas('customer')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'customerName' => $row->customer->name,
                    'title' => $row->title,
                    'description' => $row->description,
                    'short description' => $row->short_description,
                    'image' => '/uploads/images/posts/',$row->image,
                    'status' => $row->status,
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
            $paginate = Post::whereHas('customer')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'customerName' => $row->customer->name,
                    'title' => $row->title,
                    'description' => $row->description,
                    'short description' => $row->short_description,
                    'image' => '/uploads/images/posts/',$row->image,
                    'status' => $row->status,
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
    public function status($id)
    {
        $record = Post::find($id);
        if($record->status == 1) {
            $update = Post::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = Post::where('id',$id)->update([
                'status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Completed Successfully',
            ]);
        }
    }
    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Post Permanently',
        ]);
    }
}
