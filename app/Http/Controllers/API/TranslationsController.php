<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\TranslationStoreRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $language = Language::where("default", 1)->first(); // استخدام first() للحصول على أول نتيجة

        if ($language) {
            $filePath = public_path('Lang/' . $language->slug . '.json');
            $content = File::get($filePath);

            return json_decode($content, true);
        } else {
            return ['false', 'Language not found'];
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get the content of the existing file
        $content = File::get(public_path('Lang/default.json'));

        $filename = $request->input('slug');
        if (!empty($filename)) {
            $newFilePath = public_path('Lang/' . $filename . '.json');
            File::put($newFilePath, $content);
            return ['success' => true, 'message' => 'File created.'];
        } else {
            return ['success' => false, 'message' => 'Invalid filename provided.'];
        }
    }

    public function show(Request $request, $slug)
    {
        $filePath = public_path('Lang/' . $slug . '.json');
        if ($request['key'] || $request['key'] != "") {
            $searchKey = $request['key'];
            if (File::exists($filePath)) {
                $content = File::get($filePath);
                $jsonData = json_decode($content, true);

                $filteredData = [];
                foreach ($jsonData as $key => $value) {
                    $keyLower = strtolower($key); // تحويل الكلمة الرئيسية في المصفوفة إلى حروف صغيرة
                    $valueLower = strtolower($value); // تحويل القيمة في المصفوفة إلى حروف صغيرة

                    if (strpos($keyLower, $searchKey) !== false) {
                        $filteredData[$key] = $value;
                    }
                }
                return response()->json(['success' => true, 'data' => $filteredData]);
            } else {
                return response()->json(['success' => false, 'message' => 'الملف غير موجود.'], 404);
            }
        } else {
            if (File::exists($filePath)) {
                $content = File::get($filePath);
                return response()->json(['success' => true, 'data' => json_decode($content)]);
            } else {
                return response()->json(['success' => false, 'message' => 'الملف غير موجود.'], 404);
            }
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $filePath = public_path('Lang/' . $slug . '.json');


        $record = json_decode(File::get($filePath), true);

        $key = $request['key'];
        $value = $request['value'];

        if (array_key_exists($key, $record)) {

            $record[$key] = $value;
        } else {

            $record[$key] = $value;
        }

        File::put($filePath, json_encode($record, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'message' => 'The key has been updated or added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
