@extends('app')

@section('content')
    @include('inc._header')

    <div class="page">
        <div class="container">
            <h1 class="title is-3">{{ $market->name }}</h1>

            @if (isset($product))
            <form method="POST" action="{{ route('nosuper.product.update', $product->id) }}" enctype="multipart/form-data">
                @method('PUT')
            @else
            <form method="POST" action="{{ route('nosuper.product.store') }}" enctype="multipart/form-data">
            @endif
                @csrf

                <input type="hidden" name="market_id" value="{{ $market->id }}" />

                <div class="field">
                    <label for="name" class="label">Status</label>
                    <div class="control select">
                        <select name="status" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="1" @if (isset($product) && $product->status == 1) selected @endif>Ativado</option>
                            <option value="0" @if (isset($product) && $product->status == 0) selected @endif>Desativado</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <div class="control">
                        <input type="text" name="name" value="{{ isset($product) ? $product->name : null }}" id="name" class="input" required />
                    </div>
                </div>

                <div class="field">
                    <label for="price" class="label">Preço</label>
                    <div class="control">
                        <input type="text" name="price" value="{{ isset($product) ? $product->price : null }}" id="price" class="input mask-money" required />
                    </div>
                </div>

                <div class="field">
                    <label for="brand" class="label">Marca</label>
                    <div class="control select">
                        <select name="brand">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if (isset($product) && $product->brand_id == $brand->id) selected @endif>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="category" class="label">Categoria</label>
                    <div class="control select">
                        <select name="category" required>
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (isset($product) && $product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="subcategory" class="label">Subcategoria</label>
                    <div class="control select">
                        <select name="subcategory">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @if (isset($product) && $product->subcategory_id == $subcategory->id) selected @endif>{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="images" class="label">Imagens</label>
                    <div class="control">
                        <input type="file" name="images[]" id="images" multiple />
                    </div>
                </div>

                @if (isset($product))
                    <div class="images">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/uploads/products/' . $image->image) }}" alt="{{ $product->name }}" style="width: 200px;" />
                        @endforeach
                    </div>
                @endif

                <div class="control">
                    <button type="submit" class="button is-link">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>

    @include('inc._footer')
@endsection
