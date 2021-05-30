<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'seller_id',
        'desc',
        'price',
        // 'cover',
        'name',
        'unit',
        'quantity',
        'slug',
        'discount',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function coverPhotos()
    {
        return $this->hasMany(FileImage::class, 'ref_id')->where(
            'type',
            'products'
        );
    }
}
