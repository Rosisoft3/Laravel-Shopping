<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name', 
        'firstname',
        'professionnal',
        'civility',
        'company',
        'address',
        'addressbis',
        'bp',
        'postal',
        'city',
        'phone',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }   
}
