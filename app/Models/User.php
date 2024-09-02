<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticableTrait;

    protected $table = 'gemiso_se.user';

    protected $fillable = [
        'user_id',
        'password',
        'name',
        'department',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];
}

