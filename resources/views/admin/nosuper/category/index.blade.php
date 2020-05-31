@extends('app')

@section('content')
    @include('inc._header')

    <div class="page">
        <div class="container">
            <div class="columns">
                <div class="column is-6">
                    <h1 class="title is-3">Categorias</h1>
                </div>

                <div class="column is-6 has-text-right">
                    <a href="{{ route('nosuper.category.create') }}" class="button is-primary">Cadastrar</a>
                </div>
            </div>

            <div class="columns">
                <div class="column is-12">
                    <table class="table is-striped is-hoverable is-fullwidth is-responsive">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Departamento</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->department->name }}</td>
                                    <td><a href="{{ route('nosuper.category.edit', $category->id) }}" class="button is-link">Editar</a></td>
                                    <td><a href="{{ route('nosuper.category.delete', $category->id) }}" class="button is-danger">Excluir</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('inc._footer')
@endsection
