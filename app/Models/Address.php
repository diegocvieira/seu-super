<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id', 'district_id', 'cep', 'street', 'number', 'complement'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }
}
