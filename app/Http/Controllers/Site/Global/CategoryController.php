<?php

namespace App\Http\Controllers\Site\Global;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $categorys = Category::all();
        foreach($categorys as $category) {
            $data[] = [
                'id'            => $category->id,
                'name'          => $category->name,
                'description'   => $category->description,
                'slug'          => $category->slug,
                'image'         => '/uploads/images/categories/'.$category->image,
                'status'        => $category->status,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);

    }
}
