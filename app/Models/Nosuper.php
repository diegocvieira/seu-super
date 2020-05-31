<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nosuper extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'nosupers';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
