@extends('app')

@section('content')
    @include('inc._header')

    <div class="page">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-4">
                    <form method="POST" action="{{ route('nosuper.login') }}">
                        @csrf

                        <div class="field">
                            <div class="control">
                                <input type="email" name="email" placeholder="E-mail" class="input" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input type="password" name="password" placeholder="Senha" class="input" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link input">ENTRAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('inc._footer')
@endsection
