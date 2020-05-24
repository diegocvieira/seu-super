@extends('app')

@section('content')
    @include ('inc._header')

    <div class="page page-user-register flex-center">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5">
                    <form action="{{ route('user.register') }}" method="POST" id="form-user-register">
                        <h1 class="title">Bem-vindo!</h1>

                        <h2 class="subtitle">Cadastre-se totalmente grátis</h2>

                        @csrf

                        <input type="text" name="name" placeholder="Nome">

                        <input type="email" name="email" placeholder="E-mail">

                        <input type="password" name="password" placeholder="Senha" id="password" class="half">

                        <input type="password" name="password_confirmation" placeholder="Confirmar senha" class="half">

                        <button type="submit">CADASTRAR</button>

                        <p class="terms">Ao se cadastrar você confirma que leu e concorda com os <a href="#">termos de uso</a>, <a href="#">políticas de privacidade</a> e as <a href="#" class="show-modal" data-type="rules">regras de uso</a>.</p>

                        <span class="text-bottom">Já é cadastrado? <a href="{{ route('user.login') }}">Entrar</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('inc._footer')
@endsection
