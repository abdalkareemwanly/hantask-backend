<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\SearchRequest;
use App\Http\Requests\Language\storeRequest;
use App\Http\Requests\Language\updateRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class LanguageController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $info = [];
            $search = Language::where('name',$request->search)->get();
            foreach($search as $row) {
                $info[] = [
                    'id'            => $row->id,
                    'name'          => $row->name,
                    'slug'          => $row->slug,
                    'direction'     => $row->direction,
                    'status'        => $row->status,
                    'default'       => $row->default,
                ];
            }
            if($search) {
                return response()->json([
                    'success' => true,
                    'message' => 'Search Country Successfully',
                    'searchResult' => $info,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Search Country Error',
                ]);
            }
        }
        if($request->paginate) {
            $paginate = Language::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'name'          => $row->name,
                    'slug'          => $row->slug,
                    'direction'     => $row->direction,
                    'status'        => $row->status,
                    'default'       => $row->default,
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
            $paginate = Language::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'name'          => $row->name,
                    'slug'          => $row->slug,
                    'direction'     => $row->direction,
                    'status'        => $row->status,
                    'default'       => $row->default,
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
