<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'desc', 'price', 'cover', 'name', 'unit', 'slug', 'seller_id','discount'
    ];
}
