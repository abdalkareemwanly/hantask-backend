<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Seller\SearchRequest;
use App\Http\Requests\Seller\storeRequest;
use App\Http\Requests\Seller\updateRequest;
use App\Http\Traits\imageTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    use imageTrait;
    public function index(PaginatRequest $request)
    {
        $data = [];
        $paginate = $request->validated();
        if(!$paginate) {
            $sellers = User::where('user_type',0)->where('account_state',1)->paginate(10);
            foreach($sellers as $seller) {
                $imagePath = '/uploads/images/sellers';
                $data[] = [
                    'name'      => $seller->name,
                    'email'     => $seller->email,
                    'username'  => $seller->username,
                    'image'     => $imagePath . '/'.$seller->image,
                ];
            }
        } else {
            $sellers = User::where('user_type',0)->where('account_state',1)->paginate($paginate);
            foreach($sellers as $seller) {
                $imagePath = '/uploads/images/sellers';
                $data[] = [
                    'name'      => $seller->name,
                    'email'     => $seller->email,
                    'username'  => $seller->username,
                    'image'     => $imagePath . '/'.$seller->image,
                ];
            }
        }
        return response()->json([
            'success' => true,
            'mes' => 'All Sellers',
            'data' => $data
        ]);
    }
    public function store(storeRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/sellers');
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Seller Successfully',
        ]);
    }
    public function search(SearchRequest $request)
    {
        $data = $request->validated();
        $info = [];
        $search = User::where('name',$data['search'])->orWhere('username',$data['search'])->get();
        foreach($search as $row) {
            $imagePath = '/uploads/images/sellers';
            $info[] = [
                'name'      => $row->name,
                'email'     => $row->email,
                'username'  => $row->username,
                'image'     => $imagePath . '/'.$row->image,
            ];
        }
        if($search) {
            return response()->json([
                'success' => true,
                'message' => 'Search Seller Successfully',
                'searchResult' => $info,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Search Seller Error',
            ]);
        }
    }
    public function update(updateRequest $request , $id)
    {
        $record = User::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/sellers/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/sellers');
        }
        $record->update([
            'name'          => $request->name ?? $record->name,
            'email'         => $request->email ?? $record->email,
            'username'      => $request->username ?? $record->username,
            'image'         => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Seller Successfully',
        ]);
    }
    public function show($id)
    {
        $record = User::where('id',$id)->where('user_type',0)->select('id','name','email','username')->first();
        if($record) {
            return response()->json([
                'success' => true,
                'mes' => 'Show Seller Successfully',
                'user' => $record
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mes' => 'Verify The Data Entered',

            ]);
        }

    }
    public function status($id)
    {
        $record = User::find($id);
        if($record->user_status == 1) {
            $update = User::where('id',$id)->update([
                'user_status' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Deactivation Successfully',
            ]);
        } elseif($record->user_status == 0) {
            $update = User::where('id',$id)->update([
                'user_status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Successfully',
            ]);
        }
    }
    public function archived($id)
    {
        $record = User::find($id);
        if($record->account_state == 1) {
            $update = User::where('id',$id)->update([
                'account_state' => 0
            ]);
        }
        return response()->json([
            'success' => true,
            'mes' => 'Archived Seller Successfully',
        ]);
    }
    public function seller_archived()
    {
        $data = [];
        foreach(User::where('account_state' , 0)->where('user_type',0)->get() as $user) {
            $data[] = [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'username'      => $user->username,
                'phone'         => $user->phone,
                'image'         => $user->image,
            ];
        }
        return response()->json([
            'success' => true,
            'mes' => 'All Seller Archived',
            'data' => $data
        ]);
    }
    public function unArchived($id)
    {
        $record = User::find($id);
        if($record->account_state == 0) {
            $update = User::where('id',$id)->update([
                'account_state' => 1
            ]);
        }
        return response()->json([
            'success' => true,
            'mes' => 'unArchived Seller Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = User::find($id);
        $path = 'uploads/images/sellers/'.$record->image;
        if(File::exists($path)) {
            File::delete('uploads/images/sellers/'.$record->image);
        }
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Seller Successfully',
        ]);
    }
}
