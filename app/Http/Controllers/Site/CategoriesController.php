<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if(isset($request->search)) {
            $paginate = Category::where('name','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($category) {
                return [
                    'id'            => $category->id,
                    'name'          => $category->name,
                    'description'   => $category->description,
                    'slug'          => $category->slug,
                    'image'         => '/uploads/images/categories/'.$category->image,
                    'status'        => $category->status,
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
            $paginate = Category::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($category) {
                return [
                    'id'            => $category->id,
                    'name'          => $category->name,
                    'description'   => $category->description,
                    'slug'          => $category->slug,
                    'image'         => '/uploads/images/categories/'.$category->image,
                    'status'        => $category->status,
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
            $paginate = Category::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($category) {
                return [
                    'id'            => $category->id,
                    'name'          => $category->name,
                    'description'   => $category->description,
                    'slug'          => $category->slug,
                    'image'         => '/uploads/images/categories/'.$category->image,
                    'status'        => $category->status,
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
