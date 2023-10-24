<?php
namespace App\Http\Traits;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use PhpParser\Builder\Trait_;

trait imageTrait
{
    function saveImage($image, $folder)
    {
        $fileEx = $image->getClientOriginalExtension();
        $fileName = time() . '.' . $fileEx;
        $path = $folder;
        $image->move($path, $fileName);
        return $fileName;
    }
}

