<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
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
}
