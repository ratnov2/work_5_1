<?php

namespace App\Providers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FakerImageProvider extends Base {

    public function loremflickr(string $dir = '', int $width = 500, int $height = 500) : string
    {
        $name = empty($dir) ? Str::random(6) . '.jpg' : $dir . '/' . Str::random(6) . '.jpg';

        Storage::put('public/' . $name, file_get_contents("https://loremflickr.com/$width/$height"));

        return "/storage/" . $name;
    }
    
}