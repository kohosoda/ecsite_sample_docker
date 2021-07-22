<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'postalcode', 'region', 'addressline1', 'addressline2', 'phonenumber',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // SoldItemへのリレーション
    public function soldItems(): HasMany
    {
        return $this->hasMany('App\Models\SoldItem');
    }

    // お気に入り機能。Itemへのリレーション
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Item', 'likes')->withTimestamps();
    }
}

