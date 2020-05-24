@extends('app')

@section('content')
    @include ('inc._header')

    <div class="page page-user-register flex-center">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5">
                    <form action="{{ route('user.login') }}" method="POST" id="form-user-login">
                        <h1 class="title">Bem-vindo de volta!</h1>

                        <h2 class="subtitle">Acesse seu perfil para começar</h2>

                        @csrf

                        <input type="email" name="email" placeholder="E-mail">

                        <input type="password" name="password" placeholder="Senha">

                        <button type="submit">ENTRAR</button>

                        <a href="#" class="password-recover">Recuperar senha</a>

                        <span class="text-bottom">Não tem uma conta? <a href="{{ route('user.register') }}">Cadastrar</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('inc._footer')
@endsection
