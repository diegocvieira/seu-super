<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function save(Request $request)
    {
        $userId = Auth::user()->id;
        $marketId = $request->market_id;

        $user = User::findOrFail($userId);
        $market = Market::findOrFail($marketId);

        $cartProducts = $market->cartProducts();

        // if ($market->free_shipping_from && $market->free_shipping_from <= $cartProducts['total']) {
        //     $freightPrice = 0.00;
        // } else {
            $freight = $this->calculateFreight($marketId, $request->district_id)->getData();

            if (!$freight->success) {
                $data['success'] = false;
                $data['message'] = $freight->message;
                return response()->json($data);
            }

            $freightPrice = $freight->price;
        // }

        if (in_array(_formatDateToDB($request->delivery_date), $this->unavailableDates())) {
            $data['success'] = false;
            $data['message'] = 'Data indisponível para pedidos.';
            return response()->json($data);
        }

        if ($request->payment_type == '1') {
            $paymentName = $request->payment_money;
        } else if ($request->payment_type == '2') {
            $paymentName = $request->payment_debit;
        } else {
            $paymentName = $request->payment_credit;
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'cellphone' => _removeNonNumericCharacters($request->cellphone),
                'telephone' => _removeNonNumericCharacters($request->telephone),
                'birthdate' => _formatDateToDB($request->birthdate),
                'gender' => $request->gender,
                'cpf_cnpj' => _removeNonNumericCharacters($request->cpf_cnpj),
                'rg' => $request->rg
            ]);

            Address::updateOrCreate(['user_id' => $userId], [
                'cep' => _removeNonNumericCharacters($request->cep),
                'street' => $request->street,
                'number' => $request->number,
                'district_id' => $request->district_id,
                'complement' => $request->complement
            ]);

            $order = Order::create([
                'code' => round(microtime(true)),
                'status' => 2,
                'market_id' => $marketId,
                'user_id' => $userId,
                'payment' => $paymentName,
                'money_change' => $request->payment_type == '1' ? _formatRealToDolar($request->money_change) : null,
                'freight_price' => $freightPrice,
                'separation_price' => _separationPrice(),
                'instructions' => $request->instructions,
                'delivery_date' => _formatDateToDB($request->delivery_date),
                'delivery_hour' => $request->delivery_hour,
                'cep' => _removeNonNumericCharacters($user->addresses()->first()->cep),
                'district' => $user->addresses()->first()->district->name,
                'street' => $user->addresses()->first()->street,
                'number' => $user->addresses()->first()->number,
                'complement' => $user->addresses()->first()->complement
            ]);

            foreach ($cartProducts['products'] as $product) {
                $order->products()->create([
                    'product_id' => $product->id,
                    'image_id' => $product->image_id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->qtd,
                    'message' => $product->message
                ]);
            }

            app('App\Http\Controllers\CartController')->clear($market->id);

            $data['success'] = true;
            $data['route'] = route('home');
            session()->flash('session_flash', 'Pedido realizado com sucesso!');
        } catch (\Throwable $th) {
            $data['success'] = false;
            // $data['message'] = $th->getMessage();
            $data['message'] = _defaultErrorMessage();
        }

        return response()->json($data);
    }

    public function calculateFreight($marketId, $districtId)
    {
        $market = Market::with(['freights' => function ($query) use ($districtId) {
                $query->where('district_id', $districtId);
            }])
            ->whereHas('freights', function ($query) use ($districtId) {
                $query->where('district_id', $districtId);
            })
            ->where('id', $marketId)
            ->select('id')
            ->first();

        if ($market) {
            $data['success'] = true;
            $data['price'] = $market->freights->first()->pivot->price;
        } else {
            $data['success'] = false;
            $data['message'] = 'Infelizmente o supermercado não aceita entregas para o seu bairro.';
        }

        return response()->json($data);
    }

    public function unavailableDates()
    {
        $orders = Order::selectRaw('DATE(created_at) AS date')
            ->groupBy('date')
            ->havingRaw('COUNT(*) >= 24')
            ->get();

        $dates = [];
        foreach ($orders as $order) {
            $dates[] = $order->date;
        }

        return $dates;
    }

    public function cancel($orderId)
    {
        $order = Order::where('user_id', Auth::user()->id)
            ->findOrFail($orderId);

        try {
            $order->update(['status' => 0]);

            session()->flash('session_flash', 'Seu pedido foi cancelado!');
        } catch (\Throwable $th) {
            session()->flash('session_flash', 'Ocorreu um erro ao cancelar o pedido. Por favor, tente novamente mais tarde.');
        }

        return redirect()->route('user.order.details', $order->code);
    }

    // public function repeat($orderId)
    // {
    //     $order = Order::with('products')
    //         ->where('user_id', Auth::user()->id)
    //         ->findOrFail($orderId);

    //     foreach ($order->products as $product) {

    //     }
    // }
}
