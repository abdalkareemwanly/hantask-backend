<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Post\StoreRequest;
use App\Http\Requests\Buyer\Post\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\Comment;
use App\Models\Post;
use App\Models\ImagePost;
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
            $paginate = Post::whereHas('buyer')->whereHas('category')->whereHas('subcategory')
                            ->whereHas('childCategory')->whereHas('country')->whereHas('city')
                ->where('title','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $count = Comment::where('post_id',$row->id)->count();
                return [
                    'id'                 => $row->id,
                    'buyer name'         => $row->buyer->name,
                    'title'              => $row->title,
                    'description'        => $row->description,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'image'              => '/uploads/images/posts/'.$row->image,
                    'category id'        => $row->category->id,
                    'category name'      => $row->category->name,
                    'subcategory id'     => $row->subcategory->id,
                    'subcategory name'   => $row->subcategory->name,
                    'childCategory id'   => $row->childCategory->id,
                    'childCategory name' => $row->childCategory->name,
                    'country id'         => $row->country->id,
                    'country name'       => $row->country->country,
                    'city id'            => $row->city->id,
                    'city name'          => $row->city->service_city,
                    'count comment'      => $count
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
            $paginate = Post::whereHas('buyer')->whereHas('category')->whereHas('subcategory')
                        ->whereHas('childCategory')->whereHas('country')->whereHas('city')
                ->where('title','like', '%' . $request->search . '%')
                ->where('buyer_id',Auth::user()->id)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $count = Comment::where('post_id',$row->id)->count();
                return [
                    'id'                 => $row->id,
                    'buyer name'         => $row->buyer->name,
                    'title'              => $row->title,
                    'description'        => $row->description,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'image'              => '/uploads/images/posts/'.$row->image,
                    'category id'        => $row->category->id,
                    'category name'      => $row->category->name,
                    'subcategory id'     => $row->subcategory->id,
                    'subcategory name'   => $row->subcategory->name,
                    'childCategory id'   => $row->childCategory->id,
                    'childCategory name' => $row->childCategory->name,
                    'country id'         => $row->country->id,
                    'country name'       => $row->country->country,
                    'city id'            => $row->city->id,
                    'city name'          => $row->city->service_city,
                    'count comment'      => $count
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
            $paginate =Post::whereHas('buyer')->whereHas('category')->whereHas('subcategory')
                        ->whereHas('childCategory')->whereHas('country')->whereHas('city')
                ->where('buyer_id',Auth::user()->id)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                $count = Comment::where('post_id',$row->id)->count();
                return [
                    'id'                 => $row->id,
                    'buyer name'         => $row->buyer->name,
                    'title'              => $row->title,
                    'description'        => $row->description,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'image'              => '/uploads/images/posts/'.$row->image,
                    'category id'        => $row->category->id,
                    'category name'      => $row->category->name,
                    'subcategory id'     => $row->subcategory->id,
                    'subcategory name'   => $row->subcategory->name,
                    'childCategory id'   => $row->childCategory->id,
                    'childCategory name' => $row->childCategory->name,
                    'country id'         => $row->country->id,
                    'country name'       => $row->country->country,
                    'city id'            => $row->city->id,
                    'city name'          => $row->city->service_city,
                    'count comment'      => $count
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
        $data['image'] = $this->saveImage($request->image,'public/uploads/images/posts');
        $store = Post::create($data);
        if($store) {
            $id = [
                'id' => $store->id
            ];
        }
        return response()->json([
            'success' => true,
            'mes' => 'Store Post Successfully',
            'data' => $id
        ]);
    }
    public function show($id)
    {
       $date = [];
        $images = [];
        $row = Post::whereHas('category')->whereHas('subcategory')->whereHas('childCategory')
            ->whereHas('country')->whereHas('city')->where('id',$id)->first();
        $countImage = ImagePost::where('post_id',$id)->get();
        foreach($countImage as $image) {
            $images[] = [
                'id'    => $image->id,
                'image' => '/uploads/images/posts/images/'.$image->image,
            ];
        }
        $post = Post::findOrFail($id);
        $buyer_id = $post->buyer_id;
        $count = Post::where('buyer_id', $buyer_id)->count();
        if(isset($image)) {
            $date[] = [
                'id'                 => $row->id,
                'buyer_name'         => $row->buyer->name,
                'buyer_image'        => '/uploads/images/users/'.$row->buyer->image,
                'count_posts'        => $count,
                'title'              => $row->title,
                'description'        => $row->description,
                'budget'             => $row->budget,
                'dead_line'          => $row->dead_line,
                'status'             => $row->status,
                'image'              => '/uploads/images/posts/'.$row->image,
                'created_at'         => $row->created_at,
                'category_id'        => $row->category->id,
                'category_name'      => $row->category->name,
                'subcategory_id'     => $row->subcategory->id,
                'subcategory_name'   => $row->subcategory->name,
                'childCategory_id'   => $row->childCategory->id,
                'childCategory_name' => $row->childCategory->name,
                'country_id'         => $row->country->id,
                'country_name'       => $row->country->country,
                'city_id'            => $row->city->id,
                'city_name'          => $row->city->service_city,
                'postimages'         => $image,
            ];

        } else {
            $date[] = [
                'id'                 => $row->id,
                'buyer_name'         => $row->buyer->name,
                'buyer_image'        => '/uploads/images/users/'.$row->buyer->image,
                'count_posts'        => $count,
                'title'              => $row->title,
                'description'        => $row->description,
                'budget'             => $row->budget,
                'dead_line'          => $row->dead_line,
                'status'             => $row->status,
                'image'              => '/uploads/images/posts/'.$row->image,
                'created_at'         => $row->created_at,
                'category_id'        => $row->category->id,
                'category_name'      => $row->category->name,
                'subcategory_id'     => $row->subcategory->id,
                'subcategory_name'   => $row->subcategory->name,
                'childCategory_id'   => $row->childCategory->id,
                'childCategory_name' => $row->childCategory->name,
                'country_id'         => $row->country->id,
                'country_name'       => $row->country->country,
                'city_id'            => $row->city->id,
                'city_name'          => $row->city->service_city,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $date,
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
    public function status($id)
    {
        $record = Post::find($id);
        if($record->status == 1) {
            $update = Post::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'The post has been cancelled successfully',
            ]);
        } elseif($record->status == 0) {
            $update = Post::where('id',$id)->update([
                'status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'The post has been displayed successfully',
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
            'title'                 => $request->title ?? $record->title,
            'description'           => $request->description ?? $record->description,
            'category_id'           => $request->category_id ?? $record->category_id,
            'subcategory_id'        => $request->subcategory_id ?? $record->subcategory_id,
            'childCategory_id'      => $request->childCategory_id ?? $record->childCategory_id,
            'country_id'            => $request->country_id ?? $record->country_id,
            'city_id'               => $request->city_id ?? $record->city_id,
            'budget'                => $request->budget ?? $record->budget,
            'dead_line'             => $request->dead_line ?? $record->dead_line,
            'image'                 => $data['image'] ?? $record->image,
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
