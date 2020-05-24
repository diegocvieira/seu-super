<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'code', 'status', 'market_id', 'user_id', 'payment', 'money_change', 'freight_price', 'separation_price', 'instructions', 'delivery_date', 'delivery_hour', 'cep', 'district', 'street', 'number', 'complement'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\OrderProduct', 'order_id', 'id');
    }

    public function market()
    {
        return $this->belongsTo('App\Models\Market', 'market_id', 'id');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                $status = 'Cancelado';
                break;

            case 1:
                $status = 'Entregue';
                break;

            default:
                $status = 'Pendente';
                break;
        }

        return $status;
    }

    public function getTotalQuantity()
    {
        return $this->products->sum('quantity');
    }

    public function getTotalPrice()
    {
        return $this->products->sum(function ($products) {
            return $products->quantity * $products->price;
        });
    }

    public function getTotal()
    {
        return $this->getTotalPrice() + $this->separation_price + $this->freight_price;
    }
}
