<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Post\Image\StoreRequest;
use App\Http\Requests\Buyer\Post\Image\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\ImagePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostImageController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request , $id)
    {
        if($request->paginate) {
            $paginate = ImagePost::whereHas('post')
                ->where('post_id',$id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'image'              => '/uploads/images/posts/images/'.$row->image,
                    'post id'            => $row->post->id,
                    'buyer name'         => $row->post->buyer->name,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
                    'post image'         => '/uploads/images/posts/'.$row->post->image,
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
            $paginate = ImagePost::whereHas('post')
                ->where('post_id',$id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'image'              => '/uploads/images/posts/images/'.$row->image,
                    'post id'            => $row->post->id,
                    'buyer name'         => $row->post->buyer->name,
                    'post title'         => $row->post->title,
                    'post description'   => $row->post->description,
                    'post image'         => '/uploads/images/posts/'.$row->post->image,
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
    public function store(StoreRequest $request , $id)
    {
        $data = $request->validated();
        $data['post_id'] = $id;
        if ($request->hasFile('image')) {
            foreach($request->file('image') as $file) {
                $imageName = $file->getClientOriginalName();
                $uniqueImageName = time().rand(99,999).$imageName;
                $file->move(public_path('uploads/images/posts/images'), $uniqueImageName);
                ImagePost::create([
                    'post_id' => $id,
                    'image'   => $uniqueImageName
                ]);
            }

        }
        return response()->json([
            'success' => true,
            'mes' => 'Store Post Image Successfully',
        ]);
    }
    public function update(UpdateRequest $request , $id)
    {
        $record = ImagePost::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/posts/images/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/posts/images');
        }
        $record->update([
            'image'          => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Post Image Successfully',
        ]);
    }
    public function delete($id)
    {
        $post = ImagePost::find($id);
        $path = 'uploads/images/posts/images/'.$post->image;
        if(File::exists($path)) {
            File::delete('uploads/images/posts/images/'.$post->image);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Post Image Successfully',
        ]);
    }
}
