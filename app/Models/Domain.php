<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'usage',
        'backup',
        'renew',
        'registered_at',
        'expired_at',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                if (strtoupper($search) == 'Y') {
                    $query->where('backup', 1);
                } else if (strtoupper($search) == 'N') {
                    $query->where('backup', 0);
                } else {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('usage', 'like', '%' . $search . '%');
                }
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function getBackupAttribute($value)
    {
        return $value == 1;
    }

    public function getRenewAttribute($value)
    {
        return $value == 1;
    }
}
