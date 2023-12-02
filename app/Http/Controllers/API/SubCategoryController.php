<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\subCategory\StoreRequest;
use App\Http\Requests\subCategory\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\ChildCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    use imageTrait;
    public function index()
    {
        $data = [];
        foreach(Subcategory::whereHas('category')->get() as $subCategory) {
            $imagePath = '/uploads/images/subCategories';
            $data[] = [
                'id' => $subCategory->id,
                'categoryName' => $subCategory->category->name,
                'name' => $subCategory->name,
                'description' => $subCategory->description,
                'slug' => $subCategory->slug,
                'image' => $imagePath.'/'.$subCategory->image,
            ];

        }
        return response()->json([
            'success' => true,
            'mes' => 'All SubCategories',
            'data' => $data
        ]);
    }
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/subCategories');
        Subcategory::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store SubCategory Successfully',
        ]);
    }
    public function update(updateRequest $request, $id)
    {
        $record = Subcategory::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/subCategories/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/subCategories');
        }
        $record->update([
            'category_id'          => $request->category_id ?? $record->category_id,
            'name'                 => $request->name ?? $record->name,
            'description'          => $request->description ?? $record->description,
            'slug'                 => $request->slug ?? $record->slug,
            'image'                => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update SubCategory Successfully',
        ]);
    }
    public function status($id)
    {
        $record = Subcategory::find($id);
        if($record->status == 1) {
            $update = Subcategory::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = Subcategory::where('id',$id)->update([
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
        $record = Subcategory::find($id);
        $child = ChildCategory::where('category_id',$id)->first();
        $path = 'uploads/images/subCategories/'.$record->image;
        if($child) {
            return response()->json([
                'success' => false,
                'mes' => 'It cannot be deleted',
            ]);
        } else {
            if(File::exists($path)) {
                File::delete('uploads/images/subCategories/'.$record->image);
            }
            $record->delete();
            return response()->json([
                'success' => true,
                'mes' => 'Deleted SubCategory Successfully',
            ]);
        }
    }
}
