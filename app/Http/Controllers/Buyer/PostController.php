<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Post\StoreRequest;
use App\Http\Requests\Buyer\Post\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostApprov;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Post::whereHas('buyer')
                ->where('title','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
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
                ->where('title','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
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
            $paginate = Post::whereHas('buyer')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
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
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['buyer_id'] = Auth::user()->id;
        $data['image'] = $this->saveImage($request->image,'uploads/images/posts');
        Post::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Post Successfully',
        ]);
    }
    public function comment($id)
    {
        $paginate = Comment::whereHas('seller')->whereHas('post')
                ->where('post_id',$id)->paginate(10);
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
    public function approve(Request $request , $id)
    {
        $PostApprov = PostApprov::where('post_id',$id)->first();
        $commentID = $request->comment_id;
        if(!$PostApprov) {
            PostApprov::create([
                'buyer_id' => Auth::user()->id,
                'post_id'  => $id,
                'comment_id' => $commentID
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Approved Post Successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mes' => 'Approved Post Alread Exsits',
            ]);
        }
    }
    public function update(UpdateRequest $request , $id)
    {
        $record = Post::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/posts/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/posts');
        }
        $record->update([
            'title'          => $request->title ?? $record->title,
            'description'    => $request->description ?? $record->description,
            'image'          => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Post Successfully',
        ]);
    }
    public function delete($id)
    {
        $post = Post::find($id);
        $path = 'uploads/images/posts/'.$post->image;
        if(File::exists($path)) {
            File::delete('uploads/images/posts/'.$post->image);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Post Successfully',
        ]);
    }
}
