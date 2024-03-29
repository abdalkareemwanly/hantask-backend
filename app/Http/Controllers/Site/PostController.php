<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Comment\storeRequest;
use App\Models\Comment;
use App\Models\ImagePost;
use App\Models\Post;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    public function index()
    {
        $data = [];
        foreach(Post::whereHas('buyer')->where('status','1')->get() as $post) {
            $data[] = [
                'id'                 => $post->id,
                'buyer name'         => $post->buyer->name,
                'title'              => $post->title,
                'description'        => $post->description,
                'budget'             => $post->budget,
                'dead_line'          => $post->dead_line,
                'image'              => '/uploads/images/posts/'.$post->image,
            ];
        }
        return response()->json([
            'status'  => true,
            'message' => 'success',
            'data'    => $data,
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
         $dataComment = '';
         $comment = Comment::whereHas('post')->where('post_id',$id)->first();
          if(isset($comment)) {
            $dataComment = true;
          } else {
            $dataComment = false;
           }
           
          $view = View::whereHas('post')->where('post_id',$id)->first();
          if(!isset($view)) {
            View::create([
                'post_id' => $id,
                'view'    => '1'
            ]);
        } else {
            $view->update([
                'view' => $view->view + 1
            ]);
        }

        if(isset($image)) {
            $date = [
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
                'dataComment'        => $dataComment,
                'view_post_count'    => $view->view
            ];

        } else {
            $date = [
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
                'dataComment'        => $dataComment,
                'view_post_count'    => $view->view
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $date,
        ]);
    }
    public function comment(storeRequest $request ,$id)
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
    public function view($id)
    {
        $view = View::whereHas('post')->where('post_id',$id)->first();
        if(!isset($view)) {
            View::create([
                'post_id' => $id,
                'view'    => '1'
            ]);
            return response()->json([
                'success' => true,
                'mes'     => 'Store View Successfully',
            ]);
        } else {
            $view->update([
                'view' => $view->view + 1
            ]);
            return response()->json([
                'success' => true,
                'mes'     => 'Update View Successfully',
            ]);
        }
    }
}
