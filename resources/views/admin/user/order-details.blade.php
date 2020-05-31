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
                        <h1 class="page-title">
                            <a href="{{ route('user.orders') }}" class="arrow-back"></a>
                            Meus pedidos
                        </h1>

                        <div class="fields columns">
                            <div class="column is-7">
                                <div class="market">
                                    <img src="{{ asset('storage/uploads/markets/' . $order->market->logo_image) }}" class="market-image" alt="{{ $order->market->name }}" />
                                    <h3 class="market-name">{{ $order->market->name }}</h3>
                                </div>

                                <div class="section">
                                    <h4 class="section-subtitle">PEDIDO</h4>
                                    <p><span>Status: </span> {{ $order->getStatus() }}</p>
                                    <p><span>Número do pedido: </span>{{ $order->code }}</p>
                                    <p><span>Quantidade: </span>{{ $order->getTotalQuantity() }}</p>
                                </div>

                                <div class="section">
                                    <h4 class="section-subtitle">VALORES</h4>
                                    <p><span>Subtotal: </span>R${{ _formatDolarToReal($order->getTotalPrice()) }}</p>
                                    <p><span>Taxa de separação: </span>R${{ _formatDolarToReal($order->separation_price) }}</p>
                                    <p><span>Entrega: </span>R${{ _formatDolarToReal($order->freight_price) }}</p>
                                    <p><span>Total: </span>R${{ _formatDolarToReal($order->getTotal()) }}</p>
                                </div>

                                <div class="section">
                                    <h4 class="section-subtitle">AGENDAMENTO</h4>
                                    <p><span>Data do pedido: </span>{{ _formatDateToBR($order->created_at) }}</p>
                                    <p><span>Data da entrega: </span>{{ _formatDateToBR($order->delivery_date) }}</p>
                                    <p><span>Horário da entrega: </span>{{ $order->delivery_hour }}</p>
                                </div>

                                <div class="section">
                                    <h4 class="section-subtitle">INSTRUÇÕES</h4>
                                    <p><span>Se algum produto está faltando: </span>{{ $order->products_missing }}</p>
                                    @if ($order->instructions)
                                        <p><span>Mensagem: </span>{{ $order->instructions }}</p>
                                    @endif
                                </div>

                                <div class="section">
                                    <h4 class="section-subtitle">PAGAMENTO E ENTREGA</h4>
                                    <p><span>Pagamento: </span>{{ $order->payment }}</p>
                                    @if ($order->money_change)
                                        <p><span>Troco: </span>R${{ _formatDolarToReal($order->money_change) }}</p>
                                    @endif
                                    <p>
                                        <span>Endereço: </span>
                                        {{ _formatCep($order->cep) }}
                                        <br>
                                        {{ $order->street }}, {{ $order->number }}
                                        @if ($order->complement)
                                            - {{ $order->complement }}
                                        @endif
                                        <br>
                                        {{ $order->district }}
                                    </p>
                                </div>

                                <div class="section">
                                    <!-- <a href="" class="btn-repeat-order">REPETIR PEDIDO</a> -->

                                    @if ($order->status == 2)
                                        <a href="{{ route('order.cancel', $order->id) }}" class="btn-cancel-order">Cancelar pedido</a>
                                    @endif
                                </div>
                            </div>

                            <div class="column is-5">
                                <div class="products-container">
                                    <h3 class="products-title">LISTA DE COMPRAS</h3>

                                    @foreach ($order->products as $product)
                                        <div class="product">
                                            <a href="{{ route('product-show', [$order->market->slug, $product->product->slug]) }}" target="_blank">
                                                <img src="{{ $product->getImage() }}" class="image" alt="{{ $product->name }}">

                                                <p class="price">R${{ _formatDolarToReal($product->price * $product->quantity) }}</p>

                                                <h3 class="name">
                                                    {{ $product->name }}
                                                    <br><i>{{ $product->message }}</i>
                                                </h3>

                                                <p class="product-qtd">{{ $product->quantity }}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include ('inc._footer')
@endsection
