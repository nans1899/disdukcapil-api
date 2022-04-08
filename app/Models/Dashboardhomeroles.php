<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboardhomeroles extends Model
{
    use HasFactory;

    protected $table = 'dashboardhomeroles';

    protected $fillable = [
        'name', //
        'dashboardhome_id', //
        'roles_id', //
    ];

    public function roles ()
    {
        return $this->belongsTo(Roles::class, 'roles_id');
    }
}
