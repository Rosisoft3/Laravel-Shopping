<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'shipping', 'tax', 'user_id', 'state_id', 'payment', 'reference', 'pick', 'total',
    ];

    public function getPaymentTextAttribute($value)
    {
        $texts = [
          'carte' => 'Carte bancaire',
          'virement' => 'Virement',
          'cheque' => 'Chèque',
          'mandat' => 'Mandat administratif',
        ];

        return $texts[$this->payment];
    }

    public function getTotalOrderAttribute()
    {
        return $this->total + $this->shipping;
    }

    public function getTvaAttribute()
    {
        return $this->tax > 0 ? $this->total / (1 + $this->tax) * $this->tax : 0;
    }

    public function getHtAttribute()
    {
        return $this->total / (1 + $this->tax);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function payment_infos()
    {
        return $this->hasOne(Payment::class);
    }
}
