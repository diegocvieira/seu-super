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
                    <form action="{{ route('user.data') }}" method="POST" id="form-user-config">
                        @csrf

                        @method('PUT')

                        <div class="fields-container">
                            <h1 class="page-title">Meus dados</h1>

                            <div class="fields columns">
                                <div class="column is-3 has-text-right">
                                    <h4 class="fields-title">Dados pessoais</h4>
                                </div>

                                <div class="group column is-8 is-offset-1">
                                    <div class="field">
                                        <label for="name" class="label">Nome</label>

                                        <div class="control">
                                            <input type="text" name="name" value="{{ $user->name }}" id="name" placeholder="Nome completo" class="form-field">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label for="gender" class="label">Gênero</label>

                                        <div class="control">
                                            <input type="radio" name="gender" value="1" id="gender1" class="is-hidden form-field" @if ($user->gender == 1) checked @endif>
                                            <label for="gender1" class="radio-label">Masculino</label>
                                            <input type="radio" name="gender" value="0" id="gender2" class="is-hidden form-field" @if (isset($user->gender) && $user->gender == 0) checked @endif>
                                            <label for="gender2" class="radio-label margin-left">Feminino</label>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label for="birthdate" class="label">Data de nascimento</label>

                                        <div class="control">
                                            <input type="text" name="birthdate" value="{{ $user->birthdate ? date('d/m/Y', strtotime($user->birthdate)) : '' }}" id="birthdate" placeholder="DD/MM/AAAA" class="form-field mask-date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fields columns">
                                <div class="column is-3 has-text-right">
                                    <h4 class="fields-title">Contato</h4>
                                </div>

                                <div class="group column is-8 is-offset-1">
                                    <div class="field">
                                        <label for="cellphone" class="label">Celular</label>

                                        <div class="control">
                                            <input type="text" name="cellphone" value="{{ $user->cellphone }}" id="cellphone" placeholder="(DDD) 9 9999-9999" class="form-field mask-cellphone">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label for="telephone" class="label">Telefone fixo</label>

                                        <div class="control">
                                            <input type="text" name="telephone" value="{{ $user->telephone }}" id="telephone" placeholder="(DDD) 9999-9999 (opcional)" class="mask-telephone">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="fields columns">
                                <div class="column is-3 has-text-right">
                                    <h4 class="fields-title">Documentos</h4>
                                </div>

                                <div class="group column is-8 is-offset-1">
                                    <div class="field">
                                        <label for="cpf_cnpj" class="label">CPF/CNPJ</label>

                                        <div class="control">
                                            <input type="text" name="cpf_cnpj" value="{{ $user->cpf_cnpj }}" id="cpf_cnpj" placeholder="Cadastro de pessoa física ou jurídica" class="form-field mask-cpf-cnpj">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label for="rg" class="label">RG</label>

                                        <div class="control">
                                            <input type="text" name="rg" value="{{ $user->rg }}" id="rg" placeholder="Carteira de identidade" class="form-field mask-rg">
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
