<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'street', 'house_no', 'city', 'state', 'pincode', 'landmark'
    ];
}
