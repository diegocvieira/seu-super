<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Market;
use App\Models\Department;

class ProductController extends Controller
{
    public function search($marketSlug, Request $request)
    {
        $market = Market::where('slug', $marketSlug)->firstOrFail();

        $keyword = $request->palavra_chave;
        $filterDepartment = $request->departamento;
        $filterCategory = $request->categoria;
        $filterSubcategory = $request->subcategoria;

        $products = Product::with('market')
            ->where('market_id', $market->id)
            ->search($keyword)
            ->filterDepartment($filterDepartment)
            ->filterCategory($filterCategory ? explode(',', $filterCategory) : null)
            ->filterSubcategory($filterSubcategory ? explode(',', $filterSubcategory) : null)
            ->paginate(20);

        $cartProducts = $market->cartProducts();

        $departments = Department::with('categories', 'categories.subcategories')
            ->orderBy('name', 'ASC')
            ->get();

        // SEO
        $headerTitle = ($keyword ?? 'Produtos') . ' em ' . $market->name . ' | NoSuper';
        $headerDesc = 'Clique para ver ' . ($keyword ?? 'produtos') . ' em ' . $market->name;

        if (\Request::ajax()) {
            return response()->json([
                'body' => view('inc._list-products', compact('products', 'keyword'))->render(),
                'headerUrl' => \Request::getRequestUri(),
                'headerTitle' => $headerTitle
            ]);
        } else {
            return view('market.show', compact('products', 'market', 'cartProducts', 'departments', 'keyword', 'filterDepartment', 'filterCategory', 'filterSubcategory', 'headerTitle', 'headerDesc'));
        }
    }

    public function show($marketSlug, $productSlug)
    {
        $market = Market::where('slug', $marketSlug)->firstOrFail();

        $product = Product::where('market_id', $market->id)
            ->where('slug', $productSlug)
            ->with('category.department', 'subcategory')
            ->firstOrFail();

        $headerTitle = $product->name . ' | NoSuper';
        $headerDescription = $market->name . ' | NoSuper';
        $headerCanonical = route(\Request::route()->getName(), [$market->slug, $product->slug]);
        $headerImage = asset('images/default-product.png');

        $relatedProducts = Product::paginate(20);

        $cartProducts = $market->cartProducts();

        return view('product.show', compact('product', 'market', 'relatedProducts', 'cartProducts', 'headerTitle', 'headerDescription', 'headerImage', 'headerCanonical'));
    }
}
