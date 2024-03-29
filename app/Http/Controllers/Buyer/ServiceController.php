<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Service\storeRequest;
use App\Http\Requests\Service\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {

        if(isset($request->search)) {
            $paginate = Service::whereHas('category')->whereHas('child_category')->whereHas('seller')->whereHas('subcategory')->whereHas('service_city')->whereRelation('seller','user_type',0)
            ->where('title','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                        => $row->id,
                    'category name'             => $row->category->name,
                    'subcategory name'          => $row->subcategory->name,
                    'child category name'       => $row->child_category->name,
                    'service city name'         => $row->service_city->service_city,
                    'seller name'               => $row->seller->name,
                    'title'                     => $row->title,
                    'slug'                      => $row->slug,
                    'description'               => $row->description,
                    'image'                     => '/uploads/images/services/'.$row->image,
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
            $paginate = Service::whereHas('category')->whereHas('child_category')->whereHas('seller')->whereHas('subcategory')->whereHas('service_city')->whereRelation('seller','user_type',0)->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                        => $row->id,
                    'category name'             => $row->category->name,
                    'subcategory name'          => $row->subcategory->name,
                    'child category name'       => $row->child_category->name,
                    'service city name'         => $row->service_city->service_city,
                    'seller name'               => $row->seller->name,
                    'title'                     => $row->title,
                    'slug'                      => $row->slug,
                    'description'               => $row->description,
                    'image'                     => '/uploads/images/services/'.$row->image,
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
            $paginate = Service::whereHas('category')->whereHas('child_category')->whereHas('seller')->whereHas('subcategory')->whereHas('service_city')->whereRelation('seller','user_type',0)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                        => $row->id,
                    'category name'             => $row->category->name,
                    'subcategory name'          => $row->subcategory->name,
                    'child category name'       => $row->child_category->name,
                    'service city name'         => $row->service_city->service_city,
                    'seller name'               => $row->seller->name,
                    'title'                     => $row->title,
                    'slug'                      => $row->slug,
                    'description'               => $row->description,
                    'image'                     => '/uploads/images/services/'.$row->image,
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
    public function store(storeRequest $request)
    {
        try {
                $data = $request->all();
                $data['image'] = $this->saveImage($request->image,'uploads/images/services');
                Service::create($data);
                return response()->json([
                    'success' => true,
                    'mes' => 'Store Service Successfully',
                ]);
            } catch(Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
            }
    }
    public function update(updateRequest $request , $id)
    {
        $record = Service::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/services/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/services');
        }
        $record->update([
            'category_id'                   => $request->category_id ?? $record->category_id,
            'subcategory_id'                => $request->subcategory_id ?? $record->subcategory_id,
            'child_category_id'             => $request->child_category_id ?? $record->child_category_id,
            'seller_id'                     => $request->seller_id ?? $record->seller_id,
            'service_city_id'               => $request->service_city_id ?? $record->service_city_id,
            'title'                         => $request->title ?? $record->title,
            'slug'                          => $request->slug ?? $record->slug,
            'description'                   => $request->description ?? $record->description,
            'image'                         => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Service Successfully',
        ]);
    }
    public function status($id)
    {
        $record = Service::find($id);
        if($record->status == 1) {
            $update = Service::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = Service::where('id',$id)->update([
                'status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Successfully',
            ]);
        }
    }
    public function delete($id)
    {
        $record = Service::find($id);
        $path = 'uploads/images/services/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/services/'.$record->image);
        }
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Service Successfully',
        ]);
    }
}
