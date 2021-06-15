<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_sysadmin' => 'boolean',
        'is_admin' => 'boolean',
        'is_seller' => 'boolean',
    ];

    public function seller()
    {
        return $this->hasOne(Seller::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function getIsSysadminAttribute()
    {
        return $this->role == 'sysadmin';
    }

    public function getIsAdminAttribute()
    {
        return $this->role == 'admin' || $this->role == 'sysadmin';
    }

    public function getIsSellerAttribute()
    {
        return $this->role == 'seller';
    }
}
