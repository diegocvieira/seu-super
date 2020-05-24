<?php

namespace App\Http\Controllers;
use Agent;
use App\Models\Market;
use App\Models\Department;
use App\Models\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $market = Market::with(['payments' => function ($query) {
                $query->orderBy('type', 'ASC')
                    ->orderBy('name', 'ASC');
            }])
            ->first();

        $products = Product::where('market_id', $market->id)
            ->paginate(20);

        $cartProducts = $market->cartProducts();

        $departments = Department::with('categories', 'categories.subcategories')
            ->orderBy('name', 'ASC')
            ->get();

        return view('market.show', compact('market', 'products', 'departments', 'cartProducts'));
    }
}
