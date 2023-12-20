<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {

        if(isset($request->search)) {
            $paginate = Service::whereHas('category')->whereHas('child_category')->whereHas('seller')->whereHas('subcategory')->whereHas('service_city')
            ->where('title','like', '%' . $request->search . '%')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                        => $row->id,
                    'category name'             => $row->category->name,
                    'subcategory name'          => $row->subcategory->name,
                    'child category name'       => $row->child_category->name,
                    'service city name'         => $row->service_city->service_city,
                    'seller name'               => $row->seller->name,
                    'title'                     => $row->title,
                    'slug'                      => $row->slug,
                    'description'               => $row->description,
                    'image'                     => '/uploads/images/services/'.$row->image,
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
            $paginate = Service::whereHas('category')->whereHas('child_category')->whereHas('seller')->whereHas('subcategory')->whereHas('service_city')->paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                        => $row->id,
                    'category name'             => $row->category->name,
                    'subcategory name'          => $row->subcategory->name,
                    'child category name'       => $row->child_category->name,
                    'service city name'         => $row->service_city->service_city,
                    'seller name'               => $row->seller->name,
                    'title'                     => $row->title,
                    'slug'                      => $row->slug,
                    'description'               => $row->description,
                    'image'                     => '/uploads/images/services/'.$row->image,
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
            $paginate = Service::whereHas('category')->whereHas('child_category')->whereHas('seller')->whereHas('subcategory')->whereHas('service_city')->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($row) {
                return [
                    'id'                        => $row->id,
                    'category name'             => $row->category->name,
                    'subcategory name'          => $row->subcategory->name,
                    'child category name'       => $row->child_category->name,
                    'service city name'         => $row->service_city->service_city,
                    'seller name'               => $row->seller->name,
                    'title'                     => $row->title,
                    'slug'                      => $row->slug,
                    'description'               => $row->description,
                    'image'                     => '/uploads/images/services/'.$row->image,
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
}
