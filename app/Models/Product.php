<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name', 'slug', 'price', 'market_id', 'brand_id', 'category_id', 'subcategory_id', 'status'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('status', 1);
    }

    public function market()
    {
        return $this->belongsTo('App\Models\Market', 'market_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory', 'subcategory_id', 'id');
    }

    public function images()
    {
        return $this->belongsToMany('App\Models\Image', 'products_images', 'product_id', 'image_id');
    }

    public function getImage()
    {
        if ($this->images->first()) {
            return asset('storage/uploads/products/' . $this->images->first()->image);
        } else {
            return asset('images/default-product.png');
        }
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('name', 'LIKE', '%' . $keyword . '%');
        }
    }

    public function scopeFilterDepartment($query, $department)
    {
        if ($department) {
            return $query->whereHas('category.department', function ($query) use ($department) {
                $query->where('slug', $department);
            });
        }
    }

    public function scopeFilterCategory($query, $category)
    {
        if ($category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->whereIn('slug', $category);
            });
        }
    }

    public function scopeFilterSubcategory($query, $subcategory)
    {
        if ($subcategory) {
            return $query->whereHas('subcategory', function ($query) use ($subcategory) {
                $query->whereIn('slug', $subcategory);
            });
        }
    }

    public function inCart()
    {
        if (session('cart')) {
            foreach (session('cart')['markets'] as $cartMarket) {
                if ($cartMarket['marketId'] == $this->market_id) {
                    foreach ($cartMarket['products'] as $key => $cartProduct) {
                        if ($cartProduct['productId'] == $this->id) {
                            return $cartProduct;
                        }
                    }
                }
            }
        }

        return false;
    }

    protected static function boot()
	{
	    parent::boot();

		static::addGlobalScope('active', function(Builder $builder) {
	        $builder->where(function ($builder) {
	        	$builder->isActive();
	        });
	    });
	}
}
