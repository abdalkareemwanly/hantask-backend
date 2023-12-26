<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\JobRequest;
use App\Http\Requests\Buyer\UpdateJobRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Traits\imageTrait;
use App\Models\BuyerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class JobController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = BuyerJob::whereHas('category')
                        ->whereHas('childCategory')->whereHas('city')->whereHas('country')
                        ->whereHas('subcategory')->whereHas('user')
                        ->where('title','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'category name'      => $row->category->name,
                    'subcategory name'   => $row->subcategory->name,
                    'childCategory name' => $row->childCategory->name,
                    'country name'       => $row->country->country,
                    'city name'          => $row->city->service_city,
                    'buyer name'         => $row->user->name,
                    'title'              => $row->title,
                    'slug'               => $row->slug,
                    'description'        => $row->description,
                    'image'              => '/uploads/images/jobs/'.$row->image,
                    'price'              => $row->price,
                    'view'               => $row->view,
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
            $paginate = BuyerJob::whereHas('category')
                        ->whereHas('childCategory')->whereHas('city')->whereHas('country')
                        ->whereHas('subcategory')->whereHas('user')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'category name'      => $row->category->name,
                    'subcategory name'   => $row->subcategory->name,
                    'childCategory name' => $row->childCategory->name,
                    'country name'       => $row->country->country,
                    'city name'          => $row->city->service_city,
                    'buyer name'         => $row->user->name,
                    'title'              => $row->title,
                    'slug'               => $row->slug,
                    'description'        => $row->description,
                    'image'              => '/uploads/images/jobs/'.$row->image,
                    'price'              => $row->price,
                    'view'               => $row->view,
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
            $paginate = BuyerJob::whereHas('category')
                        ->whereHas('childCategory')->whereHas('city')->whereHas('country')
                        ->whereHas('subcategory')->whereHas('user')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                 => $row->id,
                    'category name'      => $row->category->name,
                    'subcategory name'   => $row->subcategory->name,
                    'childCategory name' => $row->childCategory->name,
                    'country name'       => $row->country->country,
                    'city name'          => $row->city->service_city,
                    'buyer name'         => $row->user->name,
                    'title'              => $row->title,
                    'slug'               => $row->slug,
                    'description'        => $row->description,
                    'image'              => '/uploads/images/jobs/'.$row->image,
                    'price'              => $row->price,
                    'view'               => $row->view,
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
    public function store(JobRequest $request)
    {
        $data = $request->validated();
        $data['buyer_id'] = Auth::user()->id;
        $data['image'] = $this->saveImage($request->image,'uploads/images/jobs');
        BuyerJob::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store BuyerJob Successfully',
        ]);
    }
    public function status($id)
    {
        $record = BuyerJob::find($id);
        if($record->status == 1) {
            $update = BuyerJob::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = BuyerJob::where('id',$id)->update([
                'status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Completed Successfully',
            ]);
        }
    }
    public function show($id)
    {
        $data = [];
        $record = BuyerJob::whereHas('category')
                ->whereHas('childCategory')->whereHas('city')->whereHas('country')
                ->whereHas('subcategory')->whereHas('user')->where('id' , $id)->first();
        $data[] = [
            'id'                 => $record->id,
            'category name'      => $record->category->name,
            'subcategory name'   => $record->subcategory->name,
            'childCategory name' => $record->childCategory->name,
            'country name'       => $record->country->country,
            'city name'          => $record->city->service_city,
            'buyer name'         => $record->user->name,
            'title'              => $record->title,
            'slug'               => $record->slug,
            'description'        => $record->description,
            'image'              => '/uploads/images/jobs/'.$record->image,
            'price'              => $record->price,
            'view'               => $record->view,
        ];
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
    public function update(UpdateJobRequest $request , $id)
    {
        $record = BuyerJob::find($id);
        if(request()->hasFile('image')) {
            File::delete('uploads/images/jobs/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/jobs');
        }
        $record->update([
            'category_id'            => $request->category_id ?? $record->category_id,
            'subcategory_id'         => $request->subcategory_id ?? $record->subcategory_id,
            'child_category_id'      => $request->child_category_id ?? $record->child_category_id,
            'country_id'             => $request->country_id ?? $record->country_id,
            'city_id'                => $request->city_id ?? $record->city_id,
            'buyer_id'               => Auth::user()->id ?? $record->buyer_id,
            'title'                  => $request->title ?? $record->title,
            'slug'                   => $request->slug ?? $record->slug,
            'description'            => $request->description ?? $record->description,
            'price'                  => $request->price ?? $record->price,
            'image'                  => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update BuyerJob Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = BuyerJob::find($id);
        $path = 'uploads/images/jobs/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/jobs/'.$record->image);
        }
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete BuyerJob Successfully',
        ]);
    }
}
