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
            $paginate = Post::whereHas('buyer')->whereHas('category')->whereHas('subcategory')
                    ->whereHas('childCategory')->whereHas('country')->whereHas('city')
                    ->where('title','like', '%' . $request->search . '%')>paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'buyer_name'         => $row->buyer->name,
                    'title'              => $row->title,
                    'description'        => $row->description,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'image'              => '/uploads/images/posts/'.$row->image,
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
            $paginate =  Post::whereHas('buyer')->whereHas('category')->whereHas('subcategory')
                    ->whereHas('childCategory')->whereHas('country')->whereHas('city')
                    ->where('title','like', '%' . $request->search . '%')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'buyer_name'         => $row->buyer->name,
                    'title'              => $row->title,
                    'description'        => $row->description,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'image'              => '/uploads/images/posts/'.$row->image,
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
            $paginate = Post::whereHas('buyer')->whereHas('category')->whereHas('subcategory')
                    ->whereHas('childCategory')->whereHas('country')->whereHas('city')
                    ->where('title','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'buyer_name'         => $row->buyer->name,
                    'title'              => $row->title,
                    'description'        => $row->description,
                    'budget'             => $row->budget,
                    'dead_line'          => $row->dead_line,
                    'status'             => $row->status,
                    'image'              => '/uploads/images/posts/'.$row->image,
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
