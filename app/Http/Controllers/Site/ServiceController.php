<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $data = [];
        $services = Service::all();
        foreach($services as $service) {
            $data[] = [
                'id' => $service->id,
                'id' => $service->id,
            ];

        }
    }
}
