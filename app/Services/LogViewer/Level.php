<?php

namespace App\Services\LogViewer;

/**
 * Class Level
 * @package Rap2hpoutre\LaravelLogViewer
 */
class Level
{
    /**
     * @var array
     */
    protected $levels_classes = [
        'debug' => 'text-info',
        'info' => 'text-info',
        'notice' => 'text-info',
        'warning' => 'text-warning',
        'error' => 'text-danger',
        'critical' => 'text-danger',
        'alert' => 'text-danger',
        'emergency' => 'text-danger',
        'processed' => 'text-info',
        'failed' => 'text-warning',
    ];

    /**
     * @var array
     */
    protected $levels_imgs = [
        'debug' => 'info-circle',
        'info' => 'info-circle',
        'notice' => 'info-circle',
        'warning' => 'exclamation-triangle',
        'error' => 'exclamation-triangle',
        'critical' => 'exclamation-triangle',
        'alert' => 'exclamation-triangle',
        'emergency' => 'exclamation-triangle',
        'processed' => 'info-circle',
        'failed' => 'exclamation-triangle'
    ];

    /**
     * @return array
     */
    public function all()
    {
        return array_keys($this->levels_imgs);
    }

    /**
     * @param $level
     * @return string
     */
    public function img($level)
    {
        return $this->levels_imgs[strtolower($level)];
    }

    /**
     * @param $level
     * @return string
     */
    public function cssClass($level)
    {
        return $this->levels_classes[strtolower($level)];
    }
}