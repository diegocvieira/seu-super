<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'slug', 'department_id'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Subcategory', 'category_id', 'id');
    }
}
