<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GeneralController extends Controller
{
    public function cacheRoutes(Request $request)
    {
        if ($request->input("cache") === "false") {
            return response()->json([
                "success" => false,
                "message" => "Parameter value is invalid",
            ], 201);
        } else {
            $output2 = Artisan::call("route:cache");
            $output1 = Artisan::call("down");
            $output3 = Artisan::call("up");
            if ($output3) {
                return response()->json([
                    "success" => true,
                    "message" => "The router has been updated successfully.",
                ]);
            }
        }
    }

    public function ClearView(Request $request)
    {
        if ($request->input("cache") === "false") {
            return response()->json([
                "success" => false,
                "message" => "Parameter value is invalid",
            ], 201);
        } else {
            $output2 = Artisan::call("view:clear");
            $output1 = Artisan::call("down");
            $output3 = Artisan::call("up");
            if ($output3) {
                return response()->json([
                    "success" => true,
                    "message" => "The router has been updated successfully.",
                ]);
            }
        }
    }

    public function ClearRoute(Request $request)
    {
        if ($request->input("cache") === "false") {
            return response()->json([
                "success" => false,
                "message" => "Parameter value is invalid",
            ], 201);
        } else {
            $output2 = Artisan::call("route:clear");
            $output1 = Artisan::call("down");
            $output3 = Artisan::call("up");
            if ($output3) {
                return response()->json([
                    "success" => true,
                    "message" => "The router has been updated successfully.",
                ]);
            }
        }
    }

    public function cacheConfig(Request $request)
    {
        if ($request->input("cache") === "false") {
            return response()->json([
                "success" => false,
                "message" => "Parameter value is invalid",
            ], 201);
        } else {
            $output2 = Artisan::call("config:cache");
            $output1 = Artisan::call("down");
            $output3 = Artisan::call("up");
            if ($output3) {
                return response()->json([
                    "success" => true,
                    "message" => "The router has been updated successfully.",
                ]);
            }
        }
    }

    public function restartServer(Request $request)
    {
        if ($request->input("cache") === "false") {
            return response()->json([
                "success" => false,
                "message" => "Parameter value is invalid",
            ], 201);
        } else {
            $output = Artisan::call("down");
            $output1 = Artisan::call("up");
            if ($output1) {
                return response()->json([
                    "success" => true,
                    "message" => "The router has been updated successfully.",
                ]);
            }
        }
    }


    public function BackupDatabase(Request $request)
    {
        if ($request->input("cache") === "false") {
            return response()->json([
                "success" => false,
                "message" => "Parameter value is invalid",
            ], 201);
        } else {
            $exitCode = Artisan::call("backup:run");
            dd($exitCode);
        }
    }
}
