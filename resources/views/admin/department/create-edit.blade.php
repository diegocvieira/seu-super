@extends('app')

@section('content')
    <div class="page">
        <div class="container">
            @if (isset($department))
            <form method="POST" action="{{ route('department-update', $department->id) }}" enctype="multipart/form-data">
                @method('PUT')
            @else
            <form method="POST" action="{{ route('department-store') }}" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="field">
                    <label for="name" class="label">Nome</label>
                    <div class="control">
                        <input type="text" name="name" value="{{ isset($department) ? $department->name : null }}" id="name" class="input" required />
                    </div>
                </div>

                <div class="field">
                    <label for="image" class="label">Imagem</label>
                    <div class="control">
                        <input type="file" name="image" id="image" class="input">
                    </div>
                </div>

                <div class="control">
                    <button type="submit" class="button is-link">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>
@endsection
