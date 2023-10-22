<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    use imageTrait;
    public function index()
    {
        $brands = Brand::all();
        foreach($brands as $brand) {
            return response()->json([
                'success' => true,
                'mes' => 'All Brands',
                'data' => [
                    'id' => $brand->id,
                    'title' => $brand->title,
                    'url' => $brand->url,
                    'image' => $brand->image,
                ],
            ]);
        }
    }
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/brands');
        Brand::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Brand Successfully',
        ]);
    }
    public function update(updateRequest $request , $id)
    {
        $record = Brand::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/brands/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/brands');
        }
        $record->update([
            'title'         => $request->title ?? $record->title,
            'url'           => $request->url ?? $record->url,
            'image'         => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Brand Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Brand::find($id);
        $path = 'uploads/images/brands/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/brands/'.$record->image);
        }
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Brand Successfully',
        ]);
    }
}
