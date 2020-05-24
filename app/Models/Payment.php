<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'name', 'slug'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
