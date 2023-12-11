<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\ExcelRequest;
use App\Http\Requests\City\storeRequest;
use App\Http\Requests\City\updateRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Country;
use App\Models\ServiceCity;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;


class CityController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = ServiceCity::whereHas('country')->where('service_city','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($city) {
                return [
                    'id'                => $city->id,
                    'service_city'      => $city->service_city,
                    'country'           => $city->country->country,
                    'status'            => $city->status,
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
            $paginate = ServiceCity::whereHas('country')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($city) {
                return [
                    'id'                => $city->id,
                    'service_city'      => $city->service_city,
                    'country'           => $city->country->country,
                    'status'            => $city->status,
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
            $paginate = ServiceCity::whereHas('country')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($city) {
                return [
                    'id'                => $city->id,
                    'service_city'      => $city->service_city,
                    'country'           => $city->country->country,
                    'status'            => $city->status,
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
        ServiceCity::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store ServiceCity Successfully'
        ]);
    }
    public function update(updateRequest $request , $id)
    {
        $record = ServiceCity::find($id);
        $record->update([
            'service_city'          => $request->service_city ?? $record->service_city,
            'country_id'            => $request->country_id ?? $record->country_id,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update ServiceCity Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = ServiceCity::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted ServiceCity Successfully',
        ]);
    }
    public function excel()
    {
        $file = '/uploads/excel/Citys.xlsx';
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
            $service_city        = $sheet->getCell("A{$i}")->getValue();
            $country_name        = $sheet->getCell("B{$i}")->getValue();
            $country = Country::where('country',$country_name)->first();
            // dd($country->id);
            $store = ServiceCity::create([
                'service_city'           => $service_city,
                'country_id'             => $country->id,
            ]);
        }
        if($store) {
            return response()->json([
                'success' => true,
                'mes' => 'Import Excel File Successfully',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'mes' => 'Error Import Excel File Successfully',
            ]);
        }
    }
}
