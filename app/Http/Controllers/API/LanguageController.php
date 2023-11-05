<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\storeRequest;
use App\Http\Requests\Language\updateRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    public function index()
    {
        $data = [];
        foreach(Language::all() as  $language) {
            $data[] = [
                'id'            => $language->id,
                'name'          => $language->name,
                'slug'          => $language->slug,
                'direction'     => $language->direction,
                'status'        => $language->status,
                'default'       => $language->default,
            ];

        }
        return response()->json([
            'success' => true,
            'mes' => 'All Languages',
            'data' => $data
        ]);
    }
    public function store(storeRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        Language::create($data);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Store Language Successfully'
        ]);
    }
    public function update(updateRequest $request , $id)
    {
        DB::beginTransaction();
        $record = Language::find($id);
        $record->update([
            'name'               => $request->name ?? $record->name,
            'slug'               => $request->slug ?? $record->slug,
            'direction'          => $request->direction ?? $record->direction,
            'status'             => $request->status ?? $record->status,
            'default'            => $request->default ?? $record->default,
        ]);
        DB::commit();
        return response()->json([
            'success' => true,
            'mes' => 'Update Language Successfully',
        ]);
        DB::rollBack();
    }
    public function update_default($id)
    {
        $record = Language::find($id);
        if($record->default == 1) {
            $update = Language::where('id',$id)->update([
                'default' => 0
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'The Default Mode Has Been Deactivated Successfully',
            ]);
        } elseif($record->default == 0) {
            $update = Language::where('id',$id)->update([
                'default' => 1
            ]);
            return response()->json([
                'success' => true,
                'mes' => 'The Default Mode Has Been Activated  Successfully',
            ]);
        }
    }
    public function delete($id)
    {
        $record = Language::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Language Successfully',
        ]);
    }
}
