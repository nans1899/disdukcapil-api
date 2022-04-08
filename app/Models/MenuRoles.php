<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRoles extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'menuroles';

    protected $fillable = [
        'menus_id',
        'roles_id'
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
    public function menus()
    {
        return $this->belongsTo(Menus::class, 'id');
    }
}
