<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Services\LogViewer\LogViewer;

class LogController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->log_viewer = new LogViewer();
    }

    public function index()
    {
        $folderFiles = [];
        if (Request::has('f')) {
            $this->log_viewer->setFolder(Crypt::decrypt($this->request::get('f')));
            $folderFiles = $this->log_viewer->getFolderFiles(true);
        }
        if (Request::has('l')) {
            $this->log_viewer->setFile(Crypt::decrypt(Request::input('l')));
        }

        if ($early_return = $this->earlyReturn()) {
            return $early_return;
        }

        $standardFormat = true;
        if($standardFormat)
        {
            $fields = [
                'level' => 'Level',
                'datetime' => 'Date',
                'message' => 'Content',
            ];
        }
        else
        {
            $fields = [
                'line_no' => 'Line number',
                'content' => 'Content',
            ];
        }

        if (Request::wantsJson()) {
            return $this->log_viewer->all();
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
        if (Request::has('f')) {
            $this->log_viewer->setFolder(Crypt::decrypt(Request::input('f')));
        }

        if (Request::has('dl')) {
            return $this->download($this->pathFromInput('dl'));
        } elseif (Request::has('clean')) {
            app('files')->put($this->pathFromInput('clean'), '');
            return $this->redirect(url()->previous());
        } elseif (Request::has('del')) {
            app('files')->delete($this->pathFromInput('del'));
            return $this->redirect(Request::url());
        } elseif (Request::has('delall')) {
            $files = ($this->log_viewer->getFolderName())
            ? $this->log_viewer->getFolderFiles(true)
            : $this->log_viewer->getFiles(true);
            foreach ($files as $file) {
                app('files')->delete($this->log_viewer->pathToLogFile($file));
            }
            return $this->redirect(Request::url());
        }
        return false;
    }

    /**
     * @param string $input_string
     * @return string
     * @throws \Exception
     */
    private function pathFromInput($input_string)
    {
        return $this->log_viewer->pathToLogFile(Crypt::decrypt(Request::input($input_string)));
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

    /**
     * @param string $data
     * @return mixed
     */
    private function download($data)
    {
        if (function_exists('response')) {
            return response()->download($data);
        }

        // For laravel 4.2
        return app('\Illuminate\Support\Facades\Response')->download($data);
    }
}
