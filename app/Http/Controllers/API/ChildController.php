<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Child\SearchRequest;
use App\Http\Requests\Child\StoreRequest;
use App\Http\Requests\Child\UpdateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\ChildCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChildController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        $data = [];
        $paginate = $request->validated();
        if(!$paginate) {
            $ChildCategory = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->paginate(10);
            foreach($ChildCategory as $child) {
                $imagePath = '/uploads/images/childs';
                $data[] = [
                    'id' => $child->id,
                    'name' => $child->name,
                    'description' => $child->description,
                    'slug' => $child->slug,
                    'image' => $imagePath.'/'.$child->image,
                    'categoryName' => $child->child_categories->name,
                    'subcategoryName' => $child->child_subcategories->name,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Childs',
                'data' => $data
            ]);
        } else {
            $ChildCategory = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->paginate($paginate);
            foreach($ChildCategory as $child) {
                $imagePath = '/uploads/images/childs';
                $data[] = [
                    'id' => $child->id,
                    'name' => $child->name,
                    'description' => $child->description,
                    'slug' => $child->slug,
                    'image' => $imagePath.'/'.$child->image,
                    'categoryName' => $child->child_categories->name,
                    'subcategoryName' => $child->child_subcategories->name,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Childs',
                'data' => $data
            ]);
        }


    }
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/childs');
        ChildCategory::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Child Successfully',
        ]);
    }
    public function search(SearchRequest $request)
    {
        $data = $request->validated();
        $info = [];
        $search = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->where('name',$data['search'])->orWhere('description',$data['search'])->get();
        foreach($search as $row) {
            $imagePath = '/uploads/images/childs';
                $info[] = [
                    'id' => $row->id,
                    'name' => $row->name,
                    'description' => $row->description,
                    'slug' => $row->slug,
                    'image' => $imagePath.'/'.$row->image,
                    'categoryName' => $row->child_categories->name,
                    'subcategoryName' => $row->child_subcategories->name,
                ];
        }
        if($search) {
            return response()->json([
                'success' => true,
                'message' => 'Search Category Successfully',
                'searchResult' => $info,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Search Category Error',
            ]);
        }
    }
    public function update(UpdateRequest $request , $id)
    {
        $record = ChildCategory::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/childs/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/childs');
        }
        $record->update([
            'category_id'          => $request->category_id ?? $record->category_id,
            'sub_category_id'      => $request->sub_category_id ?? $record->sub_category_id,
            'name'                 => $request->name ?? $record->name,
            'description'          => $request->description ?? $record->description,
            'slug'                 => $request->slug ?? $record->slug,
            'image'                => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Child Successfully',
        ]);
    }
    public function status($id)
    {
        $record = ChildCategory::find($id);
        if($record->status == 1) {
            $update = ChildCategory::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = ChildCategory::where('id',$id)->update([
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
        $record = ChildCategory::find($id);
        $path = 'uploads/images/childs/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/childs/'.$record->image);
        }
        $record->delete();
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Child Successfully',
        ]);
        DB::rollBack();
    }
}
