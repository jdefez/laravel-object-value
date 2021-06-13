<?php

namespace App\Models;

use App\Casts\DaysCast;
use App\Casts\UserConfigCast;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** @var array */
    protected $fillable = [
        'password',
        'config',
        'email',
        'name',
        'days',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'config' => UserConfigCast::class,
        'days' => DaysCast::class,
    ];
}
