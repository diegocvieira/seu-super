<header class="header-market {{ isset($header_scroll) ? 'header-scroll' : '' }} {{ isset($header_market_simple) ? 'header-market-simple' : '' }}">
    <div class="container full-width">
        <div class="columns">
            <div class="column is-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-nosuper.png') }}" alt="NoSuper" class="logo-nosuper">
                </a>
            </div>

            <div class="column is-7">
                <form action="{{ route('products-search', $market->slug) }}" method="GET" class="form-search">
                    <input type="text" name="palavra_chave" value="{{ $keyword ?? '' }}" placeholder="Pesquise no {{ $market->name }}" class="form-keyword" autocomplete="off">

                    <input type="hidden" name="departamento" value="{{ $filterDepartment ?? '' }}" class="form-department" autocomplete="off">
                    <input type="hidden" name="categoria" value="{{ $filterCategory ?? '' }}" class="form-category" autocomplete="off">
                    <input type="hidden" name="subcategoria" value="{{ $filterSubcategory ?? '' }}" class="form-subcategory" autocomplete="off">

                    <button type="submit"></button>
                </form>
            </div>

            <div class="column is-3 has-text-right">
                @include ('inc._menu')
            </div>
        </div>

        <div class="columns">
            <div class="column is-3">
                <div class="market">
                    <a href="">
                        <img src="storage/uploads/markets/{{ $market->logo_image }}" alt="{{ $market->name }}" class="market-logo">
                        <h3 class="market-name">{{ $market->name }}</h3>
                    </a>
                </div>
            </div>

            <div class="column is-5 pt-0 pb-0">
                @include('inc._market-options')
            </div>

            <div class="column is-4">
                <div class="advice">
                    <p>Entregamos qualquer valor | Sem pedido mínimo</p>
                </div>
            </div>
        </div>
    </div>
</header>
