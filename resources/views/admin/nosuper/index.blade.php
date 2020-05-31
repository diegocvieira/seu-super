@extends('app')

@section('content')
    @include('inc._header')

    <div class="page">
        <div class="container">
            <div class="columns">
                <div class="column is-12 has-text-centered">
                    <a href="{{ route('nosuper.market.index') }}" class="button is-link">Supermercados</a>
                    <a href="{{ route('nosuper.product.index') }}" class="button is-link">Produtos</a>
                    <a href="{{ route('nosuper.department.index') }}" class="button is-link">Departamentos</a>
                    <a href="{{ route('nosuper.category.index') }}" class="button is-link">Categorias</a>
                    <a href="{{ route('nosuper.subcategory.index') }}" class="button is-link">Subcategorias</a>
                </div>
            </div>
        </div>
    </div>

    @include('inc._footer')
@endsection
