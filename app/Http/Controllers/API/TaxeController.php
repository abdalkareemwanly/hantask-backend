<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\Tax\storeRequest;
use App\Http\Requests\Tax\updateRequest;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    public function index(PaginatRequest $request)
    {
        $data = [];
        $paginate = $request->validated();
        if(!$paginate) {
            $taxs = Tax::whereHas('country')->paginate(10);
            foreach($taxs as $tax) {
                $data[] = [
                    'id'            => $tax->id,
                    'tax'           => $tax->tax,
                    'country'       => $tax->country->country,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Tax',
                'data' => $data
            ]);
        } else {
            $taxs = Tax::whereHas('country')->paginate($paginate);
            foreach($taxs as $tax) {
                $data[] = [
                    'id'            => $tax->id,
                    'tax'           => $tax->tax,
                    'country'       => $tax->country->country,
                ];
            }
            return response()->json([
                'success' => true,
                'mes' => 'All Tax',
                'data' => $data
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
