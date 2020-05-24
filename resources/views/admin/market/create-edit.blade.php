@extends('app')

@section('content')
    <div class="page">
        <div class="container">
            @if (isset($market))
            <form method="POST" action="{{ route('market-update', $market->slug) }}" enctype="multipart/form-data">
                @method('PUT')
            @else
            <form method="POST" action="{{ route('market-store') }}" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <div class="control">
                        <input type="text" name="name" value="{{ isset($market) ? $market->name : null }}" id="name" class="input" required />
                    </div>
                </div>

                <div class="field">
                    <label for="logo_image" class="label">Logo</label>
                    <div class="control">
                        <input type="file" name="logo_image" id="logo_image" class="input">
                    </div>
                </div>

                <div class="field">
                    <label for="cover_image_desktop" class="label">Imagem de capa desktop</label>
                    <div class="control">
                        <input type="file" name="cover_image_desktop" id="cover_image_desktop" class="input">
                    </div>
                </div>

                <div class="field">
                    <label for="cover_image_mobile" class="label">Imagem de capa mobile</label>
                    <div class="control">
                        <input type="file" name="cover_image_mobile" id="cover_image_mobile" class="input">
                    </div>
                </div>

                <div class="field">
                    <label for="cep" class="label">CEP</label>
                    <div class="control">
                        <input type="text" name="cep" value="{{ isset($market) ? $market->cep : null }}" id="cep" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label for="district" class="label">Bairro</label>
                    <div class="control">
                        <input type="text" name="district" value="{{ isset($market) ? $market->district : null }}" id="district" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label for="street" class="label">Rua</label>
                    <div class="control">
                        <input type="text" name="street" value="{{ isset($market) ? $market->street : null }}" id="street" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label for="number" class="label">Número</label>
                    <div class="control">
                        <input type="text" name="number" value="{{ isset($market) ? $market->number : null }}" id="number" class="input" required>
                    </div>
                </div>

                <div class="field">
                    <label for="complement" class="label">Complemento</label>
                    <div class="control">
                        <input type="text" name="complement" value="{{ isset($market) ? $market->complement : null }}" id="complement" class="input">
                    </div>
                </div>

                <div class="field">
                    <label for="free_shipping_from" class="label">Frete grátis a partir de</label>
                    <div class="control">
                        <input type="text" name="free_shipping_from" value="{{ isset($market) ? _formatDolarToReal($market->free_shipping_from) : null }}" id="free_shipping_from" class="input">
                    </div>
                </div>

                <div class="field">
                    <label for="" class="label">Cartões</label>
                    @foreach ($payments as $payment)
                        @if (!isset($type) || $type != $payment->type)
                            <br>
                            @if ($payment->type == 1)
                                A vista
                            @elseif ($payment->type == 2)
                                Cartão de débito
                            @else
                                Cartão de crédito
                            @endif
                            <br>
                        @endif
                        @php $type = $payment->type; @endphp

                        <input type="checkbox" name="payments[]" value="{{ $payment->id }}" id="payment-{{ $payment->slug }}-{{ $payment->type }}" @if (isset($market_payments) && in_array($payment->id, $market_payments)) checked @endif>
                        <label for="payment-{{ $payment->slug }}-{{ $payment->type }}" class="checkbox">{{ $payment->name }}</label>
                    @endforeach
                </div>

                <div class="field">
                    <label for="" class="label">Fretes</label>
                    @foreach ($districts as $key => $district)
                        <input type="hidden" name="district_id[]" value="{{ $district->id }}">

                        @if (isset($market))
                            @foreach ($market->freights as $freight)
                                @php
                                    $market_freights[] = $freight->id;
                                @endphp

                                @if ($freight->id == $district->id)
                                    <input type="text" name="freight_price[{{ $key }}]" value="{{ _formatDolarToReal($freight->pivot->price) }}">
                                @endif
                            @endforeach
                        @endif

                        @if (!isset($market_freights) || !in_array($district->id, $market_freights))
                            <input type="text" name="freight_price[{{ $key }}]">
                        @endif

                        <label>{{ $district->name }}</label>
                        <br>
                    @endforeach
                </div>

                <div class="control">
                    <button type="submit" class="button is-link">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>
@endsection
