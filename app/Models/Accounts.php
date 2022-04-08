<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Accounts extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'users';


    protected $fillable = [
        'name',
        'email',
        'username',
        'email_verified_id',
        'password',
        'remember_token',
        'foto',
        'whatsapp',
        'slack',
        'role_id',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function roles()
    // {
    //     return $this->belongsTo(Roles::class);
    // }

}
