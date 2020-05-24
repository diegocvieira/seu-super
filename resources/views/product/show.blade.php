@php
    $body_class = 'bg-white';
@endphp

@extends ('app')

@section('content')
    @include('inc._header-market')

    <div class="page page-show-product pt-150">
        <div class="container full-width">
            <div class="columns">
                <div class="column is-9">
                    <div class="columns">
                        <div class="column is-6">
                            <div id="images">
                                <div id="image-destaque">
                                    <img src="{{ $product->getImage() }}" id="photo-zoom" alt="{{ $product->name }}" />
                                </div>

                                <div id="image-thumbs">
                                    @foreach ($product->images as $image)
                                        <img src="{{ asset('storage/uploads/products/' . $image->image) }}" class="image-thumb" alt="{{ $product->name }}" />
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="column is-6">
                            <div class="breadcrumb">
                                <a href="{{ route('products-search', $market->slug) . '?departamento=' . $product->category->department->slug }}" class="department" style="background-image: url({{ asset('storage/uploads/departments/' . $product->category->department->image) }});">
                                    {{ $product->category->department->name }}
                                </a>

                                <span class="arrow"></span>

                                <a href="{{ route('products-search', $market->slug) . '?departamento=' . $product->category->department->slug . '&categoria=' . $product->category->slug }}">
                                    {{ $product->category->name }}
                                </a>

                                @if ($product->subcategory)
                                    <span class="arrow"></span>

                                    <a href="{{ route('products-search', $market->slug) . '?departamento=' . $product->category->department->slug . '&categoria=' . $product->category->slug . '&subcategoria=' . $product->subcategory->slug }}">
                                        {{ $product->subcategory->name }}
                                    </a>
                                @endif
                            </div>

                            <div class="product" data-productImage="{{ $product->getImage() }}" data-productLink="{{ route('product-show', [$market->slug, $product->slug]) }}" data-productId="{{ $product->id }}" data-productPrice="{{ $product->price }}" data-productName="{{ $product->name }}">
                                <h1 class="product-name">{{ $product->name }}</h1>

                                <p class="product-price">R${{ _formatDolarToReal($product->price) }}</p>

                                <div class="quantity">
                                    <span>Quantidade</span>

                                    <select class="qtd">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} unidades</option>
                                        @endfor
                                    </select>

                                    <button class="add-product-cart-specific-qtd">+ Adicionar à lista</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-10">
                            <h2>Itens relacionados</h2>

                            @include ('inc._list-products', ['products' => $relatedProducts])
                        </div>
                    </div>
                </div>

                <div class="column is-3">
                    @include ('inc._cart')
                </div>
            </div>
        </div>
    </div>

    @include('inc._footer')
@endsection
