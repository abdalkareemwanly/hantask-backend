<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\subCategory\StoreRequest;
use App\Http\Requests\subCategory\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    use imageTrait;
    public function index()
    {
        foreach(Subcategory::whereHas('category')->get() as $subCategory) {
            return response()->json([
                'success' => true,
                'mes' => 'All SubCategories',
                'data' => [
                    'id' => $subCategory->id,
                    'categoryName' => $subCategory->category->name,
                    'name' => $subCategory->name,
                    'description' => $subCategory->description,
                    'slug' => $subCategory->slug,
                    'image' => $subCategory->image,
                ],
            ]);
        }

    }
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/subCategories');
        Subcategory::create($data);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Store SubCategory Successfully',
        ]);
        DB::rollBack();
    }
    public function update(updateRequest $request, $id)
    {
        DB::beginTransaction();
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
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update SubCategory Successfully',
        ]);
        DB::rollBack();
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
        DB::beginTransaction();
        $record = Subcategory::find($id);
        $path = 'uploads/images/subCategories/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/subCategories/'.$record->image);
        }
        $record->delete();
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted SubCategory Successfully',
        ]);
        DB::rollBack();
    }
}
