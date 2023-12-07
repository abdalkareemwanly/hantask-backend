<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SearchRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\updateRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $info = [];
            $search = Category::where('name',$request->search)->orWhere('description',$request->search)->get();
            foreach($search as $row) {
                $info[] = [
                    'id'            => $row->id,
                    'name'          => $row->name,
                    'description'   => $row->description,
                    'slug'          => $row->slug,
                    'image'         => '/uploads/images/categories/'.$row->image,
                    'status'        => $row->status,
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
        if($request->paginate) {
            $paginate = Category::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($category) {
                return [
                    'id'            => $category->id,
                    'name'          => $category->name,
                    'description'   => $category->description,
                    'slug'          => $category->slug,
                    'image'         => '/uploads/images/categories/'.$category->image,
                    'status'        => $category->status,
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
            $paginate = Category::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($category) {
                return [
                    'id'            => $category->id,
                    'name'          => $category->name,
                    'description'   => $category->description,
                    'slug'          => $category->slug,
                    'image'         => '/uploads/images/categories/'.$category->image,
                    'status'        => $category->status,
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
        DB::beginTransaction();
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/categories');
        DB::commit();
        Category::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Category Successfully',
        ]);
        DB::rollBack();
    }

    public function update(updateRequest $request , $id)
    {
        DB::beginTransaction();
        $record = Category::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/categories/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/categories');
        }
        $record->update([
            'name'          => $request->name ?? $record->name,
            'description'   => $request->description ?? $record->description,
            'slug'          => $request->slug ?? $record->slug,
            'image'         => $data['image'] ?? $record->image,
        ]);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update Category Successfully',
        ]);
        DB::rollBack();
    }
    public function status($id)
    {
        $record = Category::find($id);
        if($record->status == 1) {
            $update = Category::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = Category::where('id',$id)->update([
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
        $record = Category::find($id);
        $sub = Subcategory::where('category_id',$id)->first();
        if($sub) {
            return response()->json([
                'success' => false,
                'mes' => 'It cannot be deleted',
            ]);
        } else {
            $path = 'uploads/images/categories/'.$record->image;
            if(File::exists($path)) {
                File::delete('uploads/images/categories/'.$record->image);
            }
            $record->delete();
        }
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Category Successfully',
        ]);
        DB::rollBack();
    }
}
