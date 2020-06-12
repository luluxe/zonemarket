<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,
        SoftDeletes,
        HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }
}
