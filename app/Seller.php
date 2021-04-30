<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name','gst_number','trade_name'
    ];
}
