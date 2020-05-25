<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Market extends Model
{
    use SoftDeletes;

    protected $table = 'markets';

    protected $fillable = [
        'name', 'slug', 'logo_image', 'cover_image_desktop', 'cover_image_mobile', 'orders_status', 'telephone', 'cep', 'district', 'street', 'number', 'complement', 'free_shipping_from'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function payments()
    {
        return $this->belongsToMany('App\Models\Payment', 'markets_payments', 'market_id', 'payment_id');
    }

    public function freights()
    {
        return $this->belongsToMany('App\Models\District', 'markets_freights', 'market_id', 'district_id')->withPivot('price');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'market_id', 'id');
    }

    public function cartProducts()
    {
        if (!session('cart')) {
            return false;
        }

        foreach (session('cart')['markets'] as $cartMarket) {
            if ($cartMarket['marketId'] == $this->id) {
                $cartProducts['total'] = 0;

                foreach ($cartMarket['products'] as $key => $cartProduct) {
                    $product = Product::where('id', $cartProduct['productId'])->first();

                    if (!$product) {
                        continue;
                    }

                    $cartProducts['products'][$key] = $product;
                    // $cartProducts['products'][$key]['image_id'] = $product->images->first()->id;
                    $cartProducts['products'][$key]['qtd'] = $cartProduct['qtd'];
                    $cartProducts['products'][$key]['message'] = $cartProduct['message'];
                    $cartProducts['total'] += $product->price * $cartProduct['qtd'];
                }

                if (empty($cartProducts['products'])) {
                    return false;
                }

                return $cartProducts;
            }
        }
    }
}
