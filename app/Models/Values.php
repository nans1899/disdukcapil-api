<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
    use HasFactory;

    protected $table = 'values';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(Account::class);
    }
}
