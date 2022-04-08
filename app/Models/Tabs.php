<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabs extends Model
{
    use HasFactory;
    protected $table = 'tabs';

    protected $fillable = [
        'name', //
        'dashboardhome_id', //
        'no', //
        'type_id', //
    ];

    public function types()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

    public function dashboardhomes()
    {
        return $this->belongsTo(Dashboardhome::class, 'dashboardhome_id');
    }

    public function slideshows()
    {
        return $this->hasOne(Slideshows::class, 'slideshowable_id') ;
    }



}
