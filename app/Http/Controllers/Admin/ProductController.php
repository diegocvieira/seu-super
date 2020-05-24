<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Market;
use App\Models\Image;
use Str;

class ProductController extends Controller
{
    public function create($marketSlug)
    {
        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::orderBy('name', 'ASC')->get();

        return view('admin.product.create-edit', compact('marketSlug', 'brands', 'categories', 'subcategories'));
    }

    public function store(Request $request, $marketSlug)
    {
        $market = Market::where('slug', $marketSlug)->firstOrFail();

        $product = Product::create([
            'market_id' => $market->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'price' => _formatRealToDolar($request->price),
            'brand' => $request->brand,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
        ]);



        $name = $request->name;

        $images = Image::where('image', 'LIKE', '%' . $name . '%')->limit(3)->get();

        if (!$images->count()) {
            $names = explode(' ', $name);

            $images = Image::where(function ($query) use ($names) {
                foreach ($names as $name) {
                    $query->where('image', 'like', '%' . $name . '%');
                }
            })
            ->limit(3)
            ->get();
        }

        foreach ($images as $image) {
            $product->images()->attach($image->id);
        }
    }
}
