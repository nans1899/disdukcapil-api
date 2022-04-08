<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Account extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
        'nokab',
        'status',
        'foto',
        'hide'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }
}
