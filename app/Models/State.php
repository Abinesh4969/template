<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class State extends Model
{
     use SoftDeletes;

    protected $fillable = ['name', 'country_id','status'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
