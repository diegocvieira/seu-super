<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Product;
use App\Models\Market;
use App\Models\District;
use App\Models\User;
use App\Models\Order;
use Auth;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $productId = $request->productId;
        $marketId = Product::findOrFail($productId)->market_id;
        $qtd = $request->qtdVal;

        $cart = session('cart') ?? ['markets' => []];
        $productInCart = false;
        $marketInCart = false;

        foreach ($cart['markets'] as $marketKey => $market) {
            if ($market['marketId'] == $marketId) {
                $marketInCart = true;

                foreach ($market['products'] as $productKey => $product) {
                    if ($product['productId'] == $productId) {
                        $productInCart = true;

                        if ($qtd > 0) {
                            $cart['markets'][$marketKey]['products'][$productKey]['qtd'] = $qtd;
                        } else {
                            unset($cart['markets'][$marketKey]['products'][$productKey]);

                            if (count($cart['markets'][$marketKey]['products']) == 0) {
                                unset($cart['markets'][$marketKey]);
                            }
                        }

                        break;
                    }
                }
            }
        }

        if ($qtd > 0) {
            if (!$marketInCart) {
                array_push($cart['markets'], ['marketId' => $marketId, 'products' => [['productId' => $productId, 'qtd' => $qtd, 'message' => null]]]);
            } else if (!$productInCart) {
                array_push($cart['markets'][$marketKey]['products'], ['productId' => $productId, 'qtd' => $qtd, 'message' => null]);
            }
        }

        session(['cart' => $cart]);

        return session('cart');
    }

    public function clear($marketId)
    {
        $cart = session('cart');

        if (!$cart) {
            return false;
        }

        foreach ($cart['markets'] as $key => $market) {
            if ($market['marketId'] == $marketId) {
                unset($cart['markets'][$key]);

                break;
            }
        }

        count($cart['markets']) == 0 ? Session::forget('cart') : session(['cart' => $cart]);

        return true;
    }

    public function setProductMessage(Request $request)
    {
        $cart = session('cart');

        if (!$cart) {
            return false;
        }

        $productId = $request->productId;
        $marketId = Product::findOrFail($productId)->market_id;
        $message = $request->message;

        foreach ($cart['markets'] as $marketKey => $market) {
            if ($market['marketId'] == $marketId) {
                foreach ($market['products'] as $productKey => $product) {
                    if ($product['productId'] == $productId) {
                        $cart['markets'][$marketKey]['products'][$productKey]['message'] = $message;

                        session(['cart' => $cart]);

                        break;
                    }
                }
            }
        }

        return $request;
    }

    public function finish($marketSlug)
    {
        $market = Market::with(['payments' => function ($query) {
                $query->orderBy('type', 'ASC')->orderBy('name', 'ASC');
            }])
            ->where('slug', $marketSlug)
            ->firstOrFail();

        $cartProducts = $market->cartProducts();

        if (!$cartProducts) {
            return redirect()->route('home');
        }

        $districts = District::orderBy('name', 'ASC')->get();

        $user = User::with('addresses.district')->findOrFail(Auth::user()->id);

        $freightPrice = null;
        $totalPrice = null;
        if ($user->addresses->first()) {
            $freight = app('App\Http\Controllers\OrderController')->calculateFreight($market->id, $user->addresses->first()->district_id)->getData();

            if ($freight->success) {
                $freightPrice = $freight->price;
                $totalPrice = $cartProducts['total'] + _separationPrice() + $freightPrice;
            } else {
                session()->flash('session_flash', $freight->message);
            }
        }

        $unavailableDates = app('App\Http\Controllers\OrderController')->unavailableDates();

        return view('cart.finish', compact('market', 'cartProducts', 'districts', 'user', 'freightPrice', 'totalPrice', 'unavailableDates'));
    }
}
