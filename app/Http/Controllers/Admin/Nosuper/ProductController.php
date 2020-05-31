<?php

namespace App\Http\Controllers\Admin\Nosuper;

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
    public function index()
    {
        $products = Product::withoutGlobalScope('active')
            ->orderBy('name', 'ASC')
            ->paginate(50);

        return view('admin.nosuper.product.index', compact('products'));
    }

    public function create()
    {
        $market = Market::first();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.product.create-edit', compact('market', 'brands', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'market_id' => $request->market_id,
            'status' => $request->status,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'price' => _formatRealToDolar($request->price),
            'brand' => $request->brand,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
        ]);

        foreach ($request->images as $image) {
            $img = Image::create([
                'image' => _saveImageFolder($image, 'products/others', uniqid() . '_' . Str::slug($product->name, '_'))
            ]);

            $product->images()->attach($img->id);
        }

        session()->flash('session_flash', 'Produto cadastrado!');

        return redirect()->route('nosuper.product.index');

        // $name = $request->name;

        // $images = Image::where('image', 'LIKE', '%' . $name . '%')->limit(3)->get();

        // if (!$images->count()) {
        //     $names = explode(' ', $name);

        //     $images = Image::where(function ($query) use ($names) {
        //         foreach ($names as $name) {
        //             $query->where('image', 'like', '%' . $name . '%');
        //         }
        //     })
        //     ->limit(3)
        //     ->get();
        // }

        // foreach ($images as $image) {
        //     $product->images()->attach($image->id);
        // }
    }

    public function edit($id)
    {
        $product = Product::withoutGlobalScope('active')
            ->with('images')
            ->findOrFail($id);

        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::orderBy('name', 'ASC')->get();
        $market = Market::first();

        return view('admin.nosuper.product.create-edit', compact('market', 'product', 'brands', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::withoutGlobalScope('active')->findOrFail($id);

        $product->update([
            'status' => $request->status,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'price' => _formatRealToDolar($request->price),
            'brand' => $request->brand,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
        ]);

        if (isset($request->images)) {
            foreach ($request->images as $image) {
                $img = Image::create([
                    'image' => _saveImageFolder($image, 'products/others', uniqid() . '_' . Str::slug($product->name, '_'))
                ]);

                $product->images()->attach($img->id);
            }
        }

        session()->flash('session_flash', 'Produto atualizado!');

        return redirect()->route('nosuper.product.index');
    }

    public function delete($id)
    {
        Product::withoutGlobalScope('active')
            ->findOrFail($id)
            ->delete();

        session()->flash('session_flash', 'Produto deletado!');

        return redirect()->route('nosuper.product.index');
    }
}
