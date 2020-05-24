<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories';

    protected $fillable = [
        'name', 'slug', 'category_id'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
