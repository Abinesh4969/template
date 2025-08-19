<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class District extends Model
{
    //  use SoftDeletes;
    protected $fillable = [
    'name',
    'state_id',
    'status' 
  ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
