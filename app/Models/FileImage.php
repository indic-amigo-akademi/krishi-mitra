<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'ref_id'];
}
