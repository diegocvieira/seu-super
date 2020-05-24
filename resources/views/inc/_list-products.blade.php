<div class="products">
    @if (isset($keyword))
        <div class="columns">
            <div class="column is-12">
                <h4>Resultados para "{{ $keyword }}"</h4>
            </div>
        </div>
    @endif

    @if ($products->count())
        <div class="columns is-multiline">
            @foreach ($products as $product)
                <div class="column is-3">
                    <div class="product" data-productImage="{{ $product->getImage() }}" data-productLink="{{ route('product-show', [$product->market->slug, $product->slug]) }}" data-productId="{{ $product->id }}" data-productPrice="{{ $product->price }}" data-productName="{{ $product->name }}">
                        <a href="{{ route('product-show', [$product->market->slug, $product->slug]) }}" target="_blank">
                            <img src="{{ $product->getImage() }}" class="image" alt="{{ $product->name }}">

                            <h4 class="price">R${{ _formatDolarToReal($product->price) }}</h4>

                            <h3 class="name">{{ $product->name }}</h3>
                        </a>

                        <div class="add-product-cart">
                            @php $inCart = $product->inCart(); @endphp

                            <button type="button" class="remove">-</button>
                            <input type="text" class="qtd mask-number {{ $inCart ? 'fill' : '' }}" value="{{ $inCart ? $inCart['qtd'] : '0' }}" autocomplete="off" readonly>
                            <button type="button" class="add">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($products->lastPage() > 1)
            <div class="columns">
                <div class="column is-12">
                    <div class="pagination">
                        @if ($products->currentPage() > 1)
                            <a class="pagination-previous" href="{{ $products->appends(request()->query())->previousPageUrl() }}"></a>
                        @else
                            <a class="pagination-previous" disabled></a>
                        @endif

                        <span class="page-number">Página {{ $products->currentPage() }}</span>

                        @if ($products->currentPage() < $products->lastPage())
                            <a class="pagination-next" href="{{ $products->appends(request()->query())->nextPageUrl() }}"></a>
                        @else
                            <a class="pagination-next" disabled></a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="no-results">
            <img src="{{ asset('images/no-results.jpg') }}" alt="Nenhum produto encontrado">
            <p>Nenhum produto encontrado</p>
        </div>
    @endif
</div>
