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
        $data = [];
        $paginate = $request->validated();
        if(!$paginate) {
            $Subscriptions = Subscription::paginate(10);
            foreach($Subscriptions as $Subscription) {
                $imagePath = '/uploads/images/subscriptions';
                $data[] = [
                    'id' => $Subscription->id,
                    'image' => $imagePath . '/'.$Subscription->image,
                    'title' => $Subscription->title,
                    'type' => $Subscription->type,
                    'price' => '$'.$Subscription->price,
                    'connect' => $Subscription->connect,
                    'service' => $Subscription->service,
                    'job' => $Subscription->job,
                    'status' => $Subscription->status,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Subscriptions',
                'data' => $data
            ]);
        } else {
            $Subscriptions = Subscription::paginate($paginate);
            foreach($Subscriptions as $Subscription) {
                $imagePath = '/uploads/images/subscriptions';
                $data[] = [
                    'id' => $Subscription->id,
                    'image' => $imagePath . '/'.$Subscription->image,
                    'title' => $Subscription->title,
                    'type' => $Subscription->type,
                    'price' => '$'.$Subscription->price,
                    'connect' => $Subscription->connect,
                    'service' => $Subscription->service,
                    'job' => $Subscription->job,
                    'status' => $Subscription->status,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Subscriptions',
                'data' => $data
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
    public function search(SearchRequest $request)
    {
        $data = $request->validated();
        $info = [];
        $search = Subscription::where('title',$data['search'])->orWhere('type',$data['search'])->get();
        foreach($search as $row) {
            $imagePath = '/uploads/images/subscriptions';
                $info[] = [
                    'id' => $row->id,
                    'image' => $imagePath . '/'.$row->image,
                    'title' => $row->title,
                    'type' => $row->type,
                    'price' => '$'.$row->price,
                    'connect' => $row->connect,
                    'service' => $row->service,
                    'job' => $row->job,
                    'status' => $row->status,
                ];
        }
        if($search) {
            return response()->json([
                'success' => true,
                'message' => 'Search Subscription Successfully',
                'searchResult' => $info,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Search Subscription Error',
            ]);
        }
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
