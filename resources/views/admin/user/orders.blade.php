@extends ('app')

@section('content')
    @include ('inc._header')

    <div class="page page-user-orders">
        <div class="container">
            <div class="columns">
                <div class="column is-3">
                    @include ('admin.user._navigation')
                </div>

                <div class="column is-9">
                    <div class="fields-container">
                        <h1 class="page-title">Meus pedidos</h1>

                        <div class="fields columns is-multiline">
                            @foreach ($orders as $order)
                                <div class="column is-4">
                                    <div class="order">
                                        <a href="{{ route('user.order.details', $order->code) }}">
                                            <img src="{{ asset('storage/uploads/markets/' . $order->market->logo_image) }}" class="market-image" alt="{{ $order->market->name }}" />

                                            <div class="market-content">
                                                <h3 class="market-name">{{ $order->market->name }}</h3>
                                                <p class="order-date">{{ date('d/m/Y', strtotime($order->created_at)) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include ('inc._footer')
@endsection
