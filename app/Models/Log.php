<?php

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Log extends Model
{

    protected $connection = 'log';

    public function setTable($table)
    {
        $this->table = empty($table) ? date('Y-m-d') : $table;
        $this->createTable($this->table);
        return $this;
    }

    public function getTable()
    {
        return empty($this->table) ? date('Y-m-d') : $this->table;
    }

    protected function createTable($name)
    {
        if (Schema::connection('log')->hasTable($name)) {
            return;
        }
        Schema::connection('log')->create($name, function (Blueprint $table) {
            $table->increments('id');
            $table->text('message')->nullable();
            $table->string('channel')->nullable();
            $table->integer('level')->default(0);
            $table->string('level_name', 20);
            $table->string('datetime')->nullable();
            $table->longText('context')->nullable();
            $table->text('extra')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('message', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeSort($query, $sort)
    {
        $query->when($sort, function ($query, $sort) {
            $sort = explode('|', $sort);
            switch ($sort[0]) {
                default:
                    $query->orderBy($sort[0], $sort[1]);
            }
        });
    }

}
