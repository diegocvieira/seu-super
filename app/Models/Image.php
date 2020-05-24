<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'image'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
