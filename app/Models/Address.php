<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'address1',
        'address2',
        'city',
        'state',
        'pincode',
        'landmark',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullAddressAttribute()
    {
        return $this->address1 .
            ', ' .
            $this->address2 .
            ($this->city ? ', ' . $this->city : '') .
            ($this->pincode ? '-' . $this->pincode : '') .
            ($this->landmark ? ', ' . $this->landmark : '');
    }
}
