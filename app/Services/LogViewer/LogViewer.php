<?php

namespace App\Services\LogViewer;

use App\Repositories\LogRepository;
use \Illuminate\Support\Facades\Crypt;

class LogViewer
{
    /**
     * @var string file
     */
    protected $file;

    /**
     * @var Level level
     */
    protected $level;

    public function __construct()
    {
        $this->level = new Level();
        $this->file = LogRepository::getTable();
    }

    public function getFileName()
    {
        return $this->encrypted($this->file);
    }

    /**
     * @param bool $basename
     * @param string $folder
     * @return array
     */
    public function getFiles($basename = false, $folder = '')
    {
        $files = LogRepository::getAllTables();
        $files = array_reverse($files);
        return array_map([$this, 'encrypted'], array_values($files));
    }

    protected function encrypted($name)
    {
        return [
            'name' => $name,
            'encrypted' => Crypt::encrypt($name),
        ];
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function setFolder($folder)
    {
        if (app('files')->exists($folder)) {
            $this->folder = $folder;
        }
        if (is_array($this->storage_path)) {
            foreach ($this->storage_path as $value) {
                $logsPath = $value . '/' . $folder;
                if (app('files')->exists($logsPath)) {
                    $this->folder = $folder;
                    break;
                }
            }
        } else {
            if ($this->storage_path) {
                $logsPath = $this->storage_path . '/' . $folder;
                if (app('files')->exists($logsPath)) {
                    $this->folder = $folder;
                }
            }
        }
    }

    public function all($sort = '', $filter = [])
    {
        return LogRepository::setTable($this->file)
            ->sort($sort)
            ->filter($filter)
            ->paginate()
            ->transform(function ($v) {
                return array_merge([
                    'level_class' => $this->level->cssClass($v->level_name),
                    'level_img' => $this->level->img($v->level_name),
                ], $v->toArray());
            });
    }

    public function delete($name)
    {
        return LogRepository::delete($name);
    }
}
