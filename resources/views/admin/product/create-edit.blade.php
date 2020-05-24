@extends('app')

@section('content')
    <div class="page">
        <div class="container">
            @if (isset($product))
            <form method="POST" action="{{ route('product-update', $product->slug) }}" enctype="multipart/form-data">
                @method('PUT')
            @else
            <form method="POST" action="{{ route('product-store', $marketSlug) }}" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <div class="control">
                        <input type="text" name="name" value="{{ isset($product) ? $product->name : null }}" id="name" class="input" required />
                    </div>
                </div>

                <div class="field">
                    <label for="price" class="label">Preço</label>
                    <div class="control">
                        <input type="text" name="price" value="{{ isset($product) ? $product->price : null }}" id="price" class="input" required />
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
                        <select name="category">
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

                <div class="control">
                    <button type="submit" class="button is-link">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>
@endsection
