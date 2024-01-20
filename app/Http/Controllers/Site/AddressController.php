<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ServiceArea;
use App\Models\ServiceCity;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function countrys()
    {
        $data = [];
        $Countrys = Country::all();
        foreach($Countrys as $Country) {
            $data[] = [
                'id'           => $Country->id,
                'country'      => $Country->country,
                'country_code' => $Country->country_code,
                'status'       => $Country->status,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
    public function citis()
    {
        $data = [];
        $citis = ServiceCity::whereHas('country')->get();
        foreach($citis as $city) {
            $data[] = [
                'id'              => $city->id,
                'service_city'    => $city->service_city,
                'country id'      => $city->id,
                'country'         => $city->country->country,
                'country_code'    => $city->country->country_code,
                'country status'  => $city->country->status,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
    public function areas()
    {
        $data = [];
        $areas = ServiceArea::whereHas('country')->whereHas('serviceareas')->get();
        foreach($areas as $area) {
            $data[] = [
                'id'              => $area->id,
                'service_area'    => $area->service_area,
                'country id'      => $area->country->id,
                'country'         => $area->country->country,
                'country_code'    => $area->country->country_code,
                'country status'  => $area->country->status,
                'service_city id' => $area->serviceareas->id,
                'service_city'    => $area->serviceareas->service_city,
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
}
