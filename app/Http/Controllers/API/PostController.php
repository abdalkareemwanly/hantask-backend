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
        $data = [];
        $paginate = $request->validated();
        if(!$paginate) {
            $posts = Post::whereHas('customer')->paginate(10);
            foreach($posts as $post) {
                $imagePath = '/uploads/images/posts';
                $data[] = [
                    'id' => $post->id,
                    'customerName' => $post->customer->name,
                    'title' => $post->title,
                    'description' => $post->description,
                    'short description' => $post->short_description,
                    'image' => $imagePath .'/',$post->image,
                    'status' => $post->status,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Posts',
                'data' => $data
            ]);
        } else {
            $posts = Post::whereHas('customer')->paginate($paginate);
            foreach($posts as $post) {
                $imagePath = '/uploads/images/posts';
                $data[] = [
                    'id' => $post->id,
                    'customerName' => $post->customer->name,
                    'title' => $post->title,
                    'description' => $post->description,
                    'short description' => $post->short_description,
                    'image' => $imagePath .'/',$post->image,
                    'status' => $post->status,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Posts',
                'data' => $data
            ]);
        }

    }
    public function search(SearchRequest $request)
    {
        $data = $request->validated();
        $info = [];
        $search = Post::whereHas('customer')->where('title',$data['search'])->get();
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
                'message' => 'Search Post Successfully',
                'searchResult' => $info,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Search Post Error',
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
