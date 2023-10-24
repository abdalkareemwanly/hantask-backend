<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\ExcelRequest;
use App\Http\Requests\Country\storeRequest;
use App\Http\Requests\Country\updateRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class CountryController extends Controller
{
    public function index()
    {
        foreach(Country::all() as $country) {
            return response()->json([
                'success' => true,
                'mes' => 'All Languages',
                'data' => [
                    [
                        'id'                => $country->id,
                        'country'           => $country->country,
                        'country_code'      => $country->country_code,
                        'zone_status'       => $country->zone_status,
                        'latitude'          => $country->latitude,
                        'longitude'         => $country->longitude,
                        'created_at'        => $country->created_at,
                    ]
                ]
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
        $file = '/uploads/Countrys.xlsx';
        return response()->json([
            'url' => $file
        ]);
    }
    public function import(ExcelRequest $request)
    {
        $file = $request->file('file');
        $reader = new ReaderXlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->setActiveSheetIndexByName('Countrys');
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
