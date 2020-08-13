<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PingController extends Controller
{

    public function create()
    {
        return Inertia::render('Pings/Create');
    }

    public function store(Request $request)
    {
        $output = shell_exec(env('PING_PATH') . " $request->url 2>&1");
        $encode = mb_detect_encoding($output, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5', 'CP936'));
        return mb_convert_encoding($output, 'utf-8', $encode);

    }

}
