<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'qty', 'price', 'discount'
    ];
}
