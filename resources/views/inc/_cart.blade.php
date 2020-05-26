<div class="cart">
    <div class="cart-finish {{ !$cartProducts || isset($hide_btn_finish) ? 'is-hidden' : '' }}">
        <a href="{{ route('cart-finish', $market->slug) }}" class="cart-button-finish">Fazer pedido</a>
        <span class="cart-total">R${{ $cartProducts ? _formatDolarToReal($cartProducts['total']) : '' }}</span>
    </div>

    <h2 class="cart-title">LISTA DE COMPRAS</h2>

    <button type="button" data-route="{{ route('cart-clear', $market->id) }}" class="cart-clear {{ $cartProducts ? '' : 'is-hidden' }}">Limpar lista</button>

    <div class="empty-cart {{ $cartProducts ? 'is-hidden' : '' }}">
        <img src="{{ asset('images/icon-list.png') }}" alt="Lista vazia" class="icon-list">

        <p class="text">
            Sua lista está vazia
            <br>
            Adicione <span>+</span> itens para fazer o seu pedido.
        </p>
    </div>

    <div class="list-products">
        @if ($cartProducts)
            @foreach ($cartProducts['products'] as $product)
                <div class="product" data-productId="{{ $product->id }}" data-productPrice="{{ $product->price }}">
                    <a href="{{ route('product-show', [$market->slug, $product->slug]) }}" target="_blank">
                        <img src="{{ $product->getImage() }}" class="image" alt="{{ $product->name }}">

                        <h4 class="price" data-price="{{ $product->price }}">R${{ _formatDolarToReal($product->price * $product->qtd) }}</h4>

                        <h3 class="name">{{ $product->name }}</h3>
                    </a>

                    <div class="add-product-cart">
                        <button type="button" class="remove">-</button>
                        <input type="text" class="qtd mask-number fill" value="{{ $product->qtd }}" autocomplete="off" readonly>
                        <button type="button" class="add">+</button>
                    </div>

                    <button type="button" class="open-description"></button>
                    <div class="add-product-description">
                        <textarea placeholder="Deixe uma instrução para este item">{{ $product->message }}</textarea>
                        <button type="button" class="remove">Apagar</button>
                        <button type="button" class="save">Salvar</button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
