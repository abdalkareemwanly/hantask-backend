<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Tax\SearchRequest;
use App\Http\Requests\Tax\storeRequest;
use App\Http\Requests\Tax\updateRequest;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $info = [];
            $search = Tax::whereHas('country')->where('tax',$request->search)->get();
        foreach($search as $row) {
            $info[] = [
                'id'            => $row->id,
                'tax'           => $row->tax,
                'country'       => $row->country->country,
            ];
        }
        if($search) {
            return response()->json([
                'success' => true,
                'message' => 'Search Tax Successfully',
                'searchResult' => $info,
            ]);
        } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Search Tax Error',
                ]);
            }
        }
        if($request->paginate) {
            $paginate = Tax::whereHas('country')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'tax'           => $row->tax,
                    'country'       => $row->country->country,
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
            $paginate = Tax::whereHas('country')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'            => $row->id,
                    'tax'           => $row->tax,
                    'country'       => $row->country->country,
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
        $data = $request->all();
        Tax::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Tax Successfully'
        ]);
    }
    public function update(updateRequest $request , $id)
    {
        $record = Tax::find($id);
        $record->update([
            'tax'                   => $request->tax ?? $record->tax,
            'country_id'            => $request->country_id ?? $record->country_id,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Tax Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Tax::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Tax Successfully',
        ]);
    }
}
