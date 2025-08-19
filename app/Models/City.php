<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    //  use SoftDeletes;
     
    protected $fillable = [
    'name',
    'district_id',
    'status'
   ];
     public function district()
    {
        return $this->belongsTo(District::class);
    }
}
