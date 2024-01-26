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
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);

    }
}
