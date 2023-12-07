<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Area\ExcelRequest;
use App\Http\Requests\Area\SearchRequest;
use App\Http\Requests\Area\storeRequest;
use App\Http\Requests\Area\updateRequest;
use App\Http\Requests\PaginatRequest;
use App\Models\Country;
use App\Models\ServiceArea;
use App\Models\ServiceCity;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class AreaController extends Controller
{
    public function index(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $info = [];
            $search = ServiceArea::where('service_area',$request->search)->get();
            foreach($search as $row) {
                $info[] = [
                    'id'                => $row->id,
                    'service_area'      => $row->service_area,
                    'country'           => $row->country->country,
                    'city'              => $row->serviceareas->service_city,
                    'status'            => $row->status,
                    'created_at'        => $row->created_at,
                ];
            }
            if($search) {
                return response()->json([
                    'success' => true,
                    'message' => 'Search ServiceArea Successfully',
                    'searchResult' => $info,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Search ServiceArea Error',
                ]);
            }
        }
        if($request->paginate) {
            $paginate = ServiceArea::whereHas('country')->whereHas('serviceareas')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                => $row->id,
                    'service_area'      => $row->service_area,
                    'country'           => $row->country->country,
                    'city'              => $row->serviceareas->service_city,
                    'status'            => $row->status,
                    'created_at'        => $row->created_at,
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
            $paginate = ServiceArea::whereHas('country')->whereHas('serviceareas')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                => $row->id,
                    'service_area'      => $row->service_area,
                    'country'           => $row->country->country,
                    'city'              => $row->serviceareas->service_city,
                    'status'            => $row->status,
                    'created_at'        => $row->created_at,
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
