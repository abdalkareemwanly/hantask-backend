<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\ExcelRequest;
use App\Http\Requests\Country\SearchRequest;
use App\Http\Requests\Country\storeRequest;
use App\Http\Requests\Country\updateRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Country;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class CountryController extends Controller
{
    public function index(PaginatRequest $request)
    {

        if(isset($request->search)) {
            $paginate = Country::where('country',$request->search)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($country) {
                return [
                    'id'                => $country->id,
                    'country'           => $country->country,
                    'country_code'      => $country->country_code,
                    'zone_status'       => $country->zone_status,
                    'latitude'          => $country->latitude,
                    'longitude'         => $country->longitude,
                    'created_at'        => $country->created_at,
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
            $paginate = Country::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($country) {
                return [
                    'id'                => $country->id,
                    'country'           => $country->country,
                    'country_code'      => $country->country_code,
                    'zone_status'       => $country->zone_status,
                    'latitude'          => $country->latitude,
                    'longitude'         => $country->longitude,
                    'created_at'        => $country->created_at,
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
            $paginate = Country::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($country) {
                return [
                    'id'                => $country->id,
                    'country'           => $country->country,
                    'country_code'      => $country->country_code,
                    'zone_status'       => $country->zone_status,
                    'latitude'          => $country->latitude,
                    'longitude'         => $country->longitude,
                    'created_at'        => $country->created_at,
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
        Country::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store Country Successfully'
        ]);
    }

    public function update(updateRequest $request , $id)
    {
        $record = Country::find($id);
        $record->update([
            'country'               => $request->country ?? $record->country,
            'country_code'          => $request->country_code ?? $record->country_code,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Country Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Country::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Country Successfully',
        ]);
    }
    public function excel()
    {
        $file = '/uploads/excel/Countrys.xlsx';
        return response()->json([
            'url' => $file
        ]);
    }
    public function import(ExcelRequest $request)
    {
        $file = $request->file('file');
        $reader = new ReaderXlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRow('A');
        for($i = 2 ; $i <= $highestRow ; $i++) {
            $country        = $sheet->getCell("A{$i}")->getValue();
            $country_code   = $sheet->getCell("B{$i}")->getValue();
            $store = Country::create([
                'country'           => $country,
                'country_code'      => $country_code,
            ]);
        }
        return response()->json([
            'success' => true,
            'mes' => 'Import Excel File Successfully',
        ]);
    }
}
