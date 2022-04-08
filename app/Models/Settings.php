<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'loginimage',
        'loginimagestyle',
        'loginbackground',
        'logintext',
        'menuimage',
        'menuimagestyle',
        'menutext',
        'iconimage',
        'homebackground',
        'tableauserverinternal',
        'tableauserverexternal',
        'footertext'
    ];
}
