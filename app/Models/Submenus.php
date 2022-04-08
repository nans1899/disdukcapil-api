<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenus extends Model
{
    use HasFactory;
    protected $table = 'submenus';

    protected $fillable = [
        'submenuable_id',
        'submenuable_type',
        'name',
        'ref',
        'url',
        'hide',
        'no',
        'urlview',
        'site_id',
    ];

    public function menus()
    {
        return $this->belongsTo(Menus::class, 'menu_id')->with('submenus');
    }

    public function submenus()
    {
        return $this->hasMany(Submenus::class, 'id');
    }

    public function childs()
    {
        return $this->hasMany(Submenus::class, 'submenuable_id');
    }

    public function menuroles()
    {
        return $this->hasMany(MenuRoles::class, 'role_id');
    }
}
