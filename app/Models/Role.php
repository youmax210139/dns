<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use SoftDeletes;
    protected $appends = [
        'permissionNames',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return in_array(SoftDeletes::class, class_uses($this))
        ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
        : parent::resolveRouteBinding($value);
    }

    public function getPermissionNamesAttribute()
    {
        return $this->getPermissionNames()->map(function ($v) {
            return __('all.' . $v);
        })->slice(0, 8);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
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
