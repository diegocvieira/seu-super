@extends('app')

@section('content')
    <div class="page">
        <div class="container">
            @if (isset($category))
            <form method="POST" action="{{ route('nosuper.category.update', $category->id) }}" enctype="multipart/form-data">
                @method('PUT')
            @else
            <form method="POST" action="{{ route('nosuper.category.store') }}" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <div class="control">
                        <input type="text" name="name" value="{{ isset($category) ? $category->name : null }}" id="name" class="input" required />
                    </div>
                </div>

                <div class="field">
                    <label for="department" class="label">Departamento</label>
                    <div class="control select">
                        <select name="department">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if (isset($category) && $category->department_id == $department->id) selected @endif>{{ $department->name }}</option>
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
