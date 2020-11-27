<?php

namespace App\Http\Controllers;

use App\Services\LogViewer\LogViewer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Exports\LogExport;

class LogController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->log_viewer = new LogViewer();
    }

    public function index()
    {
        if (Request::has('dl')) {
            return new LogExport(Crypt::decrypt(Request::input('dl')));
        }
        
        if (Request::has('l')) {
            $this->log_viewer->setFile(Crypt::decrypt(Request::input('l')));
        }

        if ($early_return = $this->earlyReturn()) {
            return $early_return;
        }

        $standardFormat = true;
        if ($standardFormat) {
            $fields = [
                'level' => 'Level',
                'datetime' => 'Date',
                'message' => 'Content',
            ];
        } else {
            $fields = [
                'line_no' => 'Line number',
                'content' => 'Content',
            ];
        }

        if (Request::wantsJson()) {
            return $this->log_viewer->all(Request::get('sort'), Request::only('search'));
        }
        return Inertia::render('Logs/Index', [
            'filters' => Request::all('f', 'l'),
            'fields' => $this->getDataTableFields($fields, ['actions'], ['standardFormat']),
            'files' => $this->log_viewer->getFiles(true),
            'current_file' => $this->log_viewer->getFileName(),
            'standardFormat' => $standardFormat,
        ]);
    }

    private function earlyReturn()
    {
        if (Request::has('clean')) {
            // app('files')->put(Crypt::decrypt(Request::input('clean'), ''));
            // return $this->redirect(url()->previous());
        } elseif (Request::has('del')) {
            $this->log_viewer->delete(Crypt::decrypt(Request::input('del')));
            return $this->redirect(Request::url());
        }
        return false;
    }

    /**
     * @param $to
     * @return mixed
     */
    private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }

        return app('redirect')->to($to);
    }
}
