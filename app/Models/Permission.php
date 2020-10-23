<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
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
