<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use Illuminate\Http\Request;

class ChildCategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $childcategorys = ChildCategory::all();
        foreach($childcategorys as $childcategory) {
            $data[] = [
                'id'   => $childcategory->id,
                'name' => $childcategory->name,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);

    }
}
