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
        'government_id_type', 
        'government_id_number',
        'tax_id',
        'address_line',
        'city',
        'state',
        'district_id',
        'postal_code',
        'is_verified',
        // 'government_id_file',
        // 'proof_of_address_file',
        // 'live_selfie_file',
        // 'partnership_agreement_file',
        // 'contracts_file',
        // 'nda_file',
        'is_verified'
    ];

    /**
     * Relationship to the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function district() {
    return $this->belongsTo(District::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
