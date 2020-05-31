@extends('app')

@section('content')
    <div class="page">
        <div class="container">
            @if (isset($subcategory))
            <form method="POST" action="{{ route('nosuper.subcategory.update', $subcategory->id) }}" enctype="multipart/form-data">
                @method('PUT')
            @else
            <form method="POST" action="{{ route('nosuper.subcategory.store') }}" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <div class="control">
                        <input type="text" name="name" value="{{ isset($subcategory) ? $subcategory->name : null }}" id="name" class="input" required />
                    </div>
                </div>

                <div class="field">
                    <label for="category" class="label">Categoria</label>
                    <div class="control select">
                        <select name="category">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (isset($subcategory) && $subcategory->category_id == $category->id) selected @endif>{{ $category->name }}</option>
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
