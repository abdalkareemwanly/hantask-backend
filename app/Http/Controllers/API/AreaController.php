<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Area\ExcelRequest;
use App\Http\Requests\Area\storeRequest;
use App\Http\Requests\Area\updateRequest;
use App\Models\Country;
use App\Models\ServiceArea;
use App\Models\ServiceCity;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class AreaController extends Controller
{
    public function index()
    {
        $data = [];
        foreach(ServiceArea::whereHas('country')->whereHas('serviceareas')->get() as $area) {
            $data[] = [
                'id'                => $area->id,
                'service_area'      => $area->service_area,
                'country'           => $area->country->country,
                'city'              => $area->serviceareas->service_city,
                'status'            => $area->status,
                'created_at'        => $area->created_at,
            ];
        }
        return response()->json([
            'success' => true,
            'mes' => 'All ServiceArea',
            'data' => $data
        ]);
    }
    public function store(storeRequest $request)
    {
        $data = $request->all();
        ServiceArea::create($data);
        return response()->json([
            'success' => true,
            'mes' => 'Store ServiceArea Successfully'
        ]);
    }
    public function update(updateRequest $request , $id)
    {
        $record = ServiceArea::find($id);
        $record->update([
            'service_area'          => $request->service_area ?? $record->service_area,
            'service_city_id'       => $request->service_city_id ?? $record->service_city_id,
            'country_id'            => $request->country_id ?? $record->country_id,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update ServiceArea Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = ServiceArea::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted ServiceCity Successfully',
        ]);
    }
    public function excel()
    {
        $file = '/uploads/excel/Ares.xlsx';
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
            $service_area        = $sheet->getCell("A{$i}")->getValue();
            $cisty_name          = $sheet->getCell("B{$i}")->getValue();
            $country_name        = $sheet->getCell("C{$i}")->getValue();
            $cisty = ServiceCity::where('service_city',$cisty_name)->first();
            // dd($cisty);
            $country = Country::where('country',$country_name)->first();
            $store = ServiceArea::create([
                'service_area'           => $service_area,
                'service_city_id'        => $cisty->id,
                'country_id'             => $country->id,
            ]);
        }
        return response()->json([
            'success' => true,
            'mes' => 'Import Excel File Successfully',
        ]);
    }
}
