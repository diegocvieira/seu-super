<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'orders_products';

    protected $fillable = [
        'order_id', 'product_id', 'image_id', 'name', 'price', 'quantity', 'message'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'image_id', 'id');
    }

    public function getImage()
    {
        if ($this->image_id) {
            return asset('storage/uploads/products/' . $this->image->image);
        } else {
            return asset('images/default-product.png');
        }
    }
}
