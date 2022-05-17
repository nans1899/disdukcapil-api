<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    protected $table = 'menus';

    protected $fillable = [
        'parent_id',
        'site_id',
        'value',
        'name',
        'ref',
        'url',
        'urlview',
        'no',
        'hide',
        'icon'
    ];

    public function roles(){
        return $this->belongsToMany(Roles::class, 'menuroles', 'menus_id', 'id');
    }

    public function menuroles()
    {
        return $this->hasMany(MenuRoles::class, 'id');
    }

    public function childs(){
        return $this->hasMany(Menus::class, 'id');
    }
}
