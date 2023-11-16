<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $data = [];
        foreach(User::where('user_type',0)->where('user_status',1)->get() as $seller) {
            $imagePath = '/uploads/images/sellers';
            $data[] = [
                'name'      => $seller->name,
                'email'     => $seller->email,
                'username'  => $seller->username,
                'image'     => $imagePath . '/'.$seller->image,
            ];
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
