@extends ('app')

@section('content')
    @include ('inc._header')

    <div class="page page-user-config">
        <div class="container">
            <div class="columns">
                <div class="column is-3">
                    @include ('admin.user._navigation')
                </div>

                <div class="column is-9">
                    <form action="{{ route('user.access') }}" method="POST" id="form-user-config">
                        @csrf

                        @method('PUT')

                        <div class="fields-container">
                            <h1 class="page-title">Acesso</h1>

                            <div class="fields columns">
                                <div class="column is-3 has-text-right">
                                    <h4 class="fields-title">Trocar e-mail</h4>
                                </div>

                                <div class="group column is-8 is-offset-1">
                                    <div class="field">
                                        <label for="email-current" class="label">E-mail atual</label>

                                        <div class="control">
                                            <input type="email" name="email_current" id="email-current" placeholder="Digite seu e-mail" class="form-field">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 50%;">
                                        <label for="email-new" class="label">E-mail novo</label>

                                        <div class="control">
                                            <input type="email" name="email" id="email-new" placeholder="Digite seu novo e-mail" class="form-field">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 50%;">
                                        <label for="email-confirmation" class="label">Repetir e-mail novo</label>

                                        <div class="control">
                                            <input type="email" name="email_confirmation" id="email-confirmation" placeholder="Repita seu novo e-mail" class="form-field">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fields columns">
                                <div class="column is-3 has-text-right">
                                    <h4 class="fields-title">Trocar senha</h4>
                                </div>

                                <div class="group column is-8 is-offset-1">
                                    <div class="field">
                                        <label for="password-current" class="label">Senha atual</label>

                                        <div class="control">
                                            <input type="password" name="password_current" id="password-current" placeholder="Digite sua senha" class="form-field">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 50%;">
                                        <label for="password-new" class="label">Senha nova</label>

                                        <div class="control">
                                            <input type="password" name="password" id="password-new" placeholder="Digite sua nova senha" class="form-field">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 50%;">
                                        <label for="password-confirmation" class="label">Repetir senha nova</label>

                                        <div class="control">
                                            <input type="password" name="password_confirmation" id="password-confirmation" placeholder="Repita sua nova senha" class="form-field">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fields columns">
                                <div class="group column is-8 is-offset-4">
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="btn-submit">SALVAR DADOS</submit>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include ('inc._footer')
@endsection
