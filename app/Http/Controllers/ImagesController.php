<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImagesController extends Controller
{
    public function show(Filesystem $filesystem, $path)
    {
        // dd('1234');
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => storage_path('app/public/img'),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'imgages',
        ]);
        return $server->getImageResponse($path, request()->all());
    }
}
