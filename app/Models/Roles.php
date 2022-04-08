<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];



    public function menus()
    {
        return $this->belongsToMany(Menus::class, 'menuroles', 'roles_id' , 'menus_id');
    }

    public function menuroles()
    {
        return $this->hasMany(MenuRoles::class);
    }

    public function users()
    {
        return $this->hasMany(Account::class);
    }
}
