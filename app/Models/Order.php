<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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

    public static $categories = [
        'Vegetables',
        'Fruits',
        'Cereals',
        'Pulses',
        'Nuts',
        'Oils',
        'Fibre Crops',
        'Beverages',
        'Spices',
        'Sugar and starch',
        'Manure',
        // 'Farming Utilites',
        // 'Seeds',
        // 'Fertilizers',
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

    public function getCategoryAttribute()
    {
        return $this::$categories[$this->type];
    }

    public function getTotalDiscountedPriceAttribute()
    {
        return $this->price * (1 - $this->discount) * $this->qty;
    }
}
