<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\storeRequest;
use App\Http\Requests\Language\updateRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

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
    public function update(updateRequest $request, $id)
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
    PUBLIC function show($request){
        $language = Language::find($request);
        if (!$language) {
            return response()->json([
                'success' => false,
                'message' => 'Language not found',
            ], 404);
        }

        // Return the selected language as JSON
        return response()->json([
            'success' => true,
            'message' => 'Selected Language',
            'data' => [
                'id'        => $language->id,
                'name'      => $language->name,
                'slug'      => $language->slug,
                'direction' => $language->direction,
                'status'    => $language->status,
                'default'   => $language->default,
            ],
        ]);
    }
    public function update_default($id)
    {
        $language = Language::find($id);

        if (!$language) {
            return response()->json([
                'success' => false,
                'mes' => 'Language not found',
            ]);
        }

        Language::where('default', 1)->update(['default' => 0]);

        $language->update(['default' => 1]);

        return response()->json([
            'success' => true,
            'mes' => 'The Default Language Has Been Updated Successfully',
        ]);
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