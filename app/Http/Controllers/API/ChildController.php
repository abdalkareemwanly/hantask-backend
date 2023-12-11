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
        if(isset($request->search)) {
            $paginate = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->where('name','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($child) {
                return [
                    'id' => $child->id,
                    'name' => $child->name,
                    'description' => $child->description,
                    'slug' => $child->slug,
                    'image' =>'/uploads/images/childs/'.$child->image,
                    'categoryName' => $child->child_categories->name,
                    'subcategoryName' => $child->child_subcategories->name,
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
            $paginate = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($child) {
                return [
                    'id' => $child->id,
                    'name' => $child->name,
                    'description' => $child->description,
                    'slug' => $child->slug,
                    'image' =>'/uploads/images/childs/'.$child->image,
                    'categoryName' => $child->child_categories->name,
                    'subcategoryName' => $child->child_subcategories->name,
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
            $paginate = ChildCategory::whereHas('child_categories')->whereHas('child_subcategories')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($child) {
                return [
                    'id' => $child->id,
                    'name' => $child->name,
                    'description' => $child->description,
                    'slug' => $child->slug,
                    'image' =>'/uploads/images/childs/'.$child->image,
                    'categoryName' => $child->child_categories->name,
                    'subcategoryName' => $child->child_subcategories->name,
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
