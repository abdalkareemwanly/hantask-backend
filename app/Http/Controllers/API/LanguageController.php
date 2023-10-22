<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Models\User;

class LanguageController extends Controller
{
    public function storeLanguage(LanguageRequest $request)
    {
        $data = $request->validated();
        $language = Language::create($data);
        if ($language) {
            return response()->json(['message' => 'Language saved successfully']);
        } else {
            return response()->json(['error' => 'Language could not be saved'], 500);
        }
    }

    public function showAllLanguage()
    {
        $languages = Language::all();

        if ($languages->isEmpty()) {
            return response()->json(['message' => 'No languages found.'], 404);
        }

        return $languages;
    }
}