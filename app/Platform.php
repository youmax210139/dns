<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Platform extends Model
{
    use SoftDeletes;

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
