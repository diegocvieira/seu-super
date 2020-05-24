<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'cpf_cnpj', 'rg', 'cellphone', 'telephone', 'birthdate', 'gender'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id');
    }

    public function checkRequiredPersonalOrderFields()
    {
        if ($this->cpf_cnpj && $this->rg && $this->cellphone && $this->birthdate && isset($this->gender)) {
            return true;
        }

        return false;
    }

    public function checkRequiredAddressOrderFields($address)
    {
        if ($address && $address->cep && $address->street && $address->number && $address->district_id) {
            return true;
        }

        return false;
    }
}
