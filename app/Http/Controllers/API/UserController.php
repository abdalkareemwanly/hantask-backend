<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Traits\imageTrait;
use App\Models\User;
use App\Models\UserDeleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    use imageTrait;
    public function index()
    {
        $data = [];
        foreach(User::where('account_state' , 1)->get() as $user) {
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
            'mes' => 'All Users',
            'data' => $data
        ]);
    }
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $data['image'] = $this->saveImage($request->image,'uploads/images/users');
        $data['password'] = Hash::make($request->password);
        $store = User::create($data);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Store User Successfully',
        ]);
        DB::rollBack();
    }
    public function show($id)
    {
        $record = User::where('id',$id)->select('id','name','email','username')->first();
        if($record) {
            return response()->json([
                'success' => true,
                'mes' => 'Show User Successfully',
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
                'mes' => 'Deactivation Completed Successfully',
            ]);
        } elseif($record->user_status == 0) {
            $update = User::where('id',$id)->update([
                'user_status' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'Activation Completed Successfully',
            ]);
        }
    }
    public function update(UpdateRequest $request , $id)
    {
        DB::beginTransaction();
        $record = User::find($id);
        $data = $request->user();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/users/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/users');
        }
        $record->update([
            'name'          => $request->name ?? $record->name,
            'email'         => $request->email ?? $record->email,
            'username'      => $request->username ?? $record->username,
            'phone'         => $request->phone ?? $record->phone,
            'image'         => $data['image'] ?? $record->image,
        ]);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update User Successfully',
        ]);
        DB::rollBack();
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
            'mes' => 'Archived User Successfully',
        ]);
    }
    public function user_archived()
    {
        $data = [];
        foreach(User::where('account_state' , 0)->get() as $user) {
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
            'mes' => 'All Users Archived',
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
            'mes' => 'unArchived User Successfully',
        ]);
    }
    public function delete($id)
    {
        $user = User::find($id);
        $path = 'uploads/images/users/'.$user->image;
        if(File::exists($path)) {
            File::delete('uploads/images/users/'.$user->image);
        }
        $user->delete();
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Delete User Permanently',
        ]);
        DB::rollBack();
    }
}
