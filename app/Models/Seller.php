<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id', 'gstin', 'aadhaar', 'trade_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
}
