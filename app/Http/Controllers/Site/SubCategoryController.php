<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $Subcategorys = Subcategory::all();
        foreach($Subcategorys as $Subcategory) {
            $data[] = [
                'id'   => $Subcategory->id,
                'name' => $Subcategory->name,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);

    }
    public function category()
    {
        $data = [];
        foreach(Category::all() as $category) {
        $data[] = [
                'id'   => $category->id,
                'name' => $category->name,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
}
