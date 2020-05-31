<?php

namespace App\Http\Controllers\Admin\Nosuper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Market;
use App\Models\District;
use App\Models\Payment;
use Illuminate\Support\Str;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.market.index', compact('markets'));
    }

    public function create()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        $payments = Payment::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.market.create-edit', compact('payments', 'districts'));
    }

    public function store(Request $request)
    {
        $market = Market::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'cep' => $request->cep,
            'district' => $request->district,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'free_shipping_from' => _formatRealToDolar($request->free_shipping_from),
            'logo_image' => _saveImageFolder($request->logo_image, 'markets'),
            'cover_image_desktop' => _saveImageFolder($request->cover_image_desktop, 'markets'),
            'cover_image_mobile' => _saveImageFolder($request->cover_image_mobile, 'markets')
        ]);

        $market->payments()->attach($request->payments);

        $freights = array_map(function($q, $t) {
            return array('id' => $q, 'price' => $t);
        }, $request->district_id, $request->freight_price);

        foreach ($freights as $freight) {
            if ($freight['price']) {
                \DB::table('markets_freights')->insert([
                    'market_id' => $market->id,
                    'district_id' => $freight['id'],
                    'price' => _formatRealToDolar($freight['price'])
                ]);
            }
        }

        session()->flash('session_flash', 'Supermercado cadastrado!');

        return redirect()->route('nosuper.market.index');
    }

    public function edit($id)
    {
        $market = Market::with('payments', 'freights')
            ->findOrFail($id);

        $market_payments = [];
        foreach ($market->payments as $payment) {
            $market_payments[] = $payment->id;
        }

        $districts = District::orderBy('name', 'ASC')->get();
        $payments = Payment::orderBy('name', 'ASC')->get();

        return view('admin.nosuper.market.create-edit', compact('market', 'market_payments', 'districts', 'payments'));
    }

    public function update(Request $request, $id)
    {
        $market = Market::findOrFail($id);

        $market->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'cep' => $request->cep,
            'district' => $request->district,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'free_shipping_from' => _formatRealToDolar($request->free_shipping_from)
        ]);

        $market->payments()->sync($request->payments);

        $freights = array_map(function($q, $t) {
            return array('id' => $q, 'price' => $t);
        }, $request->district_id, $request->freight_price);

        $market->freights()->detach();

        foreach ($freights as $freight) {
            if ($freight['price']) {
                \DB::table('markets_freights')->insert([
                    'market_id' => $market->id,
                    'district_id' => $freight['id'],
                    'price' => _formatRealToDolar($freight['price'])
                ]);
            }
        }

        if ($request->logo_image) {
            $market->update([
                'logo_image' => _saveImageFolder($request->logo_image, 'markets')
            ]);
        }

        if ($request->cover_image_desktop) {
            $market->update([
                'cover_image_desktop' => _saveImageFolder($request->cover_image_desktop, 'markets')
            ]);
        }

        if ($request->cover_image_mobile) {
            $market->update([
                'cover_image_mobile' => _saveImageFolder($request->cover_image_mobile, 'markets')
            ]);
        }

        session()->flash('session_flash', 'Supermercado atualizado!');

        return redirect()->route('nosuper.market.index');
    }

    public function delete($id)
    {
        Market::findOrFail($id)->delete();

        session()->flash('session_flash', 'Supermercado deletado!');

        return redirect()->route('nosuper.market.index');
    }
}
