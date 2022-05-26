<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_id', 'qty', 'price', 'discount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
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
