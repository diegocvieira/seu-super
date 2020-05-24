@php
    $header_market_simple = true;
    $header_scroll = true;
@endphp

@extends ('app')

@section('content')
    @include('inc._header-market')

    <div class="page page-show-market pt-0">
        <div class="container full-width">
            <div class="market-header" style="background-image: url(storage/uploads/markets/{{ $market->cover_image_desktop }});">
                <img src="storage/uploads/markets/{{ $market->logo_image }}" alt="{{ $market->name }}" class="market-logo">

                <h1 class="market-name">{{ $market->name }}</h1>

                <p class="market-advice">Entregamos qualquer valor | Sem pedido mínimo</p>

                <form action="{{ route('products-search', $market->slug) }}" method="GET" class="form-search">
                    <input type="text" name="palavra_chave" value="{{ $keyword ?? '' }}" placeholder="Pesquise no {{ $market->name }}">

                    <input type="hidden" name="departamento" value="{{ $filterDepartment ?? '' }}" class="form-department" autocomplete="off">
                    <input type="hidden" name="categoria" value="{{ $filterCategory ?? '' }}" class="form-category" autocomplete="off">
                    <input type="hidden" name="subcategoria" value="{{ $filterSubcategory ?? '' }}" class="form-subcategory" autocomplete="off">

                    <button type="submit"></button>
                </form>
            </div>

            <div class="columns">
                <div class="column is-12">
                    @include('inc._market-options')
                </div>
            </div>

            <div class="know columns is-centered">
                <div class="column is-2">
                    <div class="item">
                        <img src="{{ asset('images/know/1.png') }}" alt="Entenda">
                        <p class="text">Selecione os itens que<br>deseja encomendar</p>
                    </div>
                </div>

                <div class="column is-2">
                    <div class="item">
                        <img src="{{ asset('images/know/2.png') }}" alt="Entenda">
                        <p class="text">Agende a entrega e<br>faça o seu pedido</p>
                    </div>
                </div>

                <div class="column is-2">
                    <div class="item">
                        <img src="{{ asset('images/know/3.png') }}" alt="Entenda">
                        <p class="text">Receba suas compras<br>no conforto de casa</p>
                    </div>
                </div>

                <div class="column is-2">
                    <div class="item">
                        <img src="{{ asset('images/know/4.png') }}" alt="Entenda">
                        <p class="text">Pague somente ao<br>receber os produtos</p>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2">
                    <div class="filters">
                        <div class="departments">
                            @foreach ($departments as $department)
                                <div class="department {{ isset($filterDepartment) && $filterDepartment != $department->slug ? 'is-hidden' : '' }} {{ isset($filterDepartment) && $filterDepartment == $department->slug ? 'active' : '' }}" data-slug="{{ $department->slug }}">
                                    <div class="department-header department-filter">
                                        <button type="button" class="department-close {{ isset($filterDepartment) && $filterDepartment == $department->slug ? '' : 'is-hidden' }}"></button>
                                        <img src="{{ asset('storage/uploads/departments/' . $department->image) }}" alt="{{ $department->name }}" class="department-image">
                                        <h4 class="department-name">{{ $department->name }}</h4>
                                    </div>

                                    <div class="categories {{ isset($filterDepartment) && $filterDepartment == $department->slug ? '' : 'is-hidden' }}">
                                        @foreach ($department->categories as $category)
                                            <div class="category {{ isset($filterCategory) && in_array($category->slug, explode(',', $filterCategory)) ? 'active' : '' }}" data-slug="{{ $category->slug }}">
                                                <h4 class="category-name category-filter">
                                                    {{ $category->name }}
                                                </h4>

                                                <div class="subcategories {{ isset($filterCategory) && in_array($category->slug, explode(',', $filterCategory)) ? '' : 'is-hidden' }}">
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <div class="subcategory {{ isset($filterSubcategory) && in_array($subcategory->slug, explode(',', $filterSubcategory)) ? 'active' : '' }}" data-slug="{{ $subcategory->slug }}">
                                                            <h4 class="subcategory-name subcategory-filter">
                                                                {{ $subcategory->name }}
                                                            </h4>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="products-json column is-7">
                    @include ('inc._list-products', ['products' => $products])
                </div>

                <div class="column is-3">
                    @include ('inc._cart')
                </div>
            </div>
        </div>

        <div class="modal modal-payment">
            <div class="modal-background"></div>
            <div class="modal-card">
                <div class="modal-card-head">
                    <img src="{{ asset('images/icon-card.png') }}" alt="Formas de pagamento" class="modal-icon">
                    <h2 class="modal-title">Formas de pagamento</h2>
                    <h3 class="modal-subtitle">{{ $market->name }}</h3>
                </div>

                <div class="modal-card-body">
                    @foreach ($market->payments as $payment)
                        @if (isset($type) && $type != $payment->type)
                            <span class="payment-type">
                                @if ($payment->type == 2)
                                    Cartão de débito
                                @elseif ($payment->type == 3)
                                    Cartão de crédito
                                @endif
                            </span>
                        @endif
                        @php $type = $payment->type; @endphp

                        <span class="{{ $payment->type == 1 ? 'payment-type' : 'payment-name' }}">{{ $payment->name }}</span>
                    @endforeach
                </div>

                <div class="modal-card-foot">
                    <p class="text">Você realizará o pagamento somente ao receber suas compras.</p>
                </div>
            </div>

            <button class="modal-close is-large" aria-label="close"></button>
        </div>

        <div class="modal modal-freight">
            <div class="modal-background"></div>
            <div class="modal-card">
                <div class="modal-card-head">
                    <img src="{{ asset('images/icon-truck.png') }}" alt="Valores da entrega" class="modal-icon">
                    <h2 class="modal-title">Valores da entrega</h2>
                    <h3 class="modal-subtitle">{{ $market->name }}</h3>
                </div>

                <div class="modal-card-body">
                    @foreach ($market->freights as $freight)
                        <div class="freight">
                            <span class="freight-name">{{ $freight->name }}</span>
                            <span class="freight-price">R$ {{ _formatDolarToReal($freight->pivot->price) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="modal-card-foot">
                    <p class="text">Além do valor da entrega também é cobrado uma taxa de separação dos produtos no valor de R5,00 por pedido.</p>
                </div>
            </div>

            <button class="modal-close is-large" aria-label="close"></button>
        </div>
    </div>

    @include('inc._footer')
@endsection
