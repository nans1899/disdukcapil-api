<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboardhome extends Model
{
    use HasFactory;
    protected $table = 'dashboardhomes';

    protected $fillable = [
        'name', //
        'type_id', //
        'hidden', //
        'no', //
    ];

    public function types()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

    public function tabs()
    {
        return $this->hasMany(Tabs::class, 'dashboardhome_id');
    }

    public function roles()
    {
        return $this->hasMany(Dashboardhomeroles::class, 'dashboardhome_id');
    }

    public function images()
    {
        return $this->hasMany(Images::class, 'imageable_id');
    }

}
