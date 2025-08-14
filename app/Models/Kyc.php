<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kyc extends Model implements HasMedia
{
     use InteractsWithMedia; 
         protected $fillable = [
        'user_id',
        'aadhaar',
        'pan_card',
        'gst_certificate',
        'upi_type',
        'upi_mobile_number',
        'account_holder_name',
        'bank_name',
        'bank_branch',
        'account_number',
        'ifsc_code',
        'is_verified',
    ];

    /**
     * Relationship to the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
