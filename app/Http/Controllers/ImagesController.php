<?php

namespace App\Http\Controllers;

use GlideImage;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function show(Request $request)
    {
        return GlideImage::create($request->path);
    }
}
