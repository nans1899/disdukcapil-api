<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshows extends Model
{
    use HasFactory;

    protected $table = 'slideshows';

    protected $fillable = [
        'name', //
        'slideshowable_id', //
        'slideshowable_type', //
    ];

    public function images()
    {
        return $this->hasMany(Images::class, 'imageable_id');
    }

}
