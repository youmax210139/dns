<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Whois;

class Domain extends Model
{
    use SoftDeletes;

    protected $appends = [
        'platform_name',
        'http_status_code'
    ];

    protected $fillable = [
        'platform_id',
        'name',
        'usage',
        'backup',
        'renew',
        'http',
        'registered_at',
        'expired_at',
    ];

    protected $casts = [
        'http' => 'array',
    ];

    protected static function booted() {
        static::creating(function ($domain) {
            if ($domain->http === null) {
                $domain->http = [];  // set empty json array
            }
        });
    }

    public function platform()
    {
        return $this->belongsTo('App\Models\Platform', 'platform_id', 'id');
    }

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
                        ->orWhere('usage', 'like', '%' . $search . '%')
                        ->orWhereHas('platform', function (Builder $query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
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

    public function getHostnameAttribute()
    {
        return Whois::getHostname($this->name);
    }

    public function getPlatformNameAttribute()
    {
        return $this->platform->name ?? '--';
    }

    public function getHttpStatusCodeAttribute()
    {
        return $this->http['Status_code'] ?? '--';
    }
}
