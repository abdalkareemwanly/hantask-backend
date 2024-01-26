<?php

namespace App\Http\Controllers\Site\Global;

use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use Illuminate\Http\Request;

class ChildCategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $childcategorys = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->get();
        foreach($childcategorys as $childcategory) {
            $data[] = [
                'id'              => $childcategory->id,
                'name'            => $childcategory->name,
                'categoryName'    => $childcategory->child_categories->name,
                'subcategoryName' => $childcategory->child_subcategories->name,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);

    }
}
