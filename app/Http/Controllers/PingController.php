<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Domain;

class PingController extends Controller
{

    public function create()
    {
        return Inertia::render('Pings/Create', [
            'domains' => Domain::orderBy('name')
                ->get()
                ->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = shell_exec(env('PING_PATH') . " -n4 $request->url 2>&1");
        } else {
            $output = shell_exec(env('PING_PATH') . " -c4 $request->url 2>&1");
        }
        $encode = mb_detect_encoding($output, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5', 'CP936'));
        return mb_convert_encoding($output, 'utf-8', $encode);

    }

}
