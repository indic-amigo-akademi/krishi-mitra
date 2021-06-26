<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'address_id',
        'order_id',
        'qty',
        'price',
        'discount',
        'status',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }


    public function getDiscountedPriceAttribute()
    {
        return $this->price * (1 - $this->discount);
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->qty;
    }

    public function getTotalDiscountedPriceAttribute()
    {
        return $this->price * (1 - $this->discount) * $this->qty;
    }
}
