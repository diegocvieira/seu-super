<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name', 'slug', 'image'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'department_id', 'id');
    }
}
