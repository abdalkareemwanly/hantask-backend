<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Subscription\SearchRequest;
use App\Http\Requests\Subscription\storeRequest;
use App\Http\Requests\Subscription\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SubscriptionController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Subscription::where('title','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'image' => '/uploads/images/subscriptions/'.$row->image,
                    'title' => $row->title,
                    'type' => $row->type,
                    'price' => '$'.$row->price,
                    'connect' => $row->connect,
                    'service' => $row->service,
                    'job' => $row->job,
                    'status' => $row->status,
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
            $paginate = Subscription::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'image' => '/uploads/images/subscriptions/'.$row->image,
                    'title' => $row->title,
                    'type' => $row->type,
                    'price' => '$'.$row->price,
                    'connect' => $row->connect,
                    'service' => $row->service,
                    'job' => $row->job,
                    'status' => $row->status,
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
            $paginate = Subscription::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id' => $row->id,
                    'image' => '/uploads/images/subscriptions/'.$row->image,
                    'title' => $row->title,
                    'type' => $row->type,
                    'price' => '$'.$row->price,
                    'connect' => $row->connect,
                    'service' => $row->service,
                    'job' => $row->job,
                    'status' => $row->status,
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
        $data = $request->validated();
        $data['image'] = $this->saveImage($request->image,'uploads/images/subscriptions');
        Subscription::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Subscription Successfully',
        ]);
    }
    public function status($id)
    {
        $record = Subscription::find($id);
        if($record->status == 1) {
            $update = Subscription::where('id',$id)->update([
                'status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->status == 0) {
            $update = Subscription::where('id',$id)->update([
                'status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Completed Successfully',
            ]);
        }
    }
    public function update(updateRequest $request , $id)
    {
        $record = Subscription::find($id);
        $data = $request->validated();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/subscriptions/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/subscriptions');
        }
        $record->update([
            'title'     => $request->title ?? $record->title,
            'type'      => $request->type ?? $record->type,
            'price'     => $request->price ?? $record->price,
            'connect'   => $request->connect ?? $record->connect,
            'image'     => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Subscription Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Subscription::find($id);
        $path = 'uploads/images/subscriptions/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/subscriptions/'.$record->image);
        }
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Subscription Successfully',
        ]);
    }
}
