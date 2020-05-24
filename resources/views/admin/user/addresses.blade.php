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
                    <form action="{{ route('user.addresses') }}" method="POST" id="form-user-config">
                        @csrf

                        @method('PUT')

                        <div class="fields-container">
                            <h1 class="page-title">Meu endereço</h1>

                            <div class="fields columns">
                                <div class="column is-3 has-text-right">
                                    <h4 class="fields-title">Endereço</h4>
                                </div>

                                <div class="group column is-8 is-offset-1">
                                    <div class="field" style="flex: 0 0 50%;">
                                        <label for="cep" class="label">CEP</label>

                                        <div class="control">
                                            <input type="text" name="cep" value="{{ $user->addresses->first() ? $user->addresses->first()->cep : '' }}" id="cep" placeholder="Digite seu CEP" class="form-field mask-cep">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 70%;">
                                        <label for="street" class="label">Endereço</label>

                                        <div class="control">
                                            <input type="text" name="street" value="{{ $user->addresses->first() ? $user->addresses->first()->street : '' }}" id="street" placeholder="Rua, avenida, travessa..." class="form-field">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 200px;">
                                        <label for="number" class="label">Número</label>

                                        <div class="control">
                                            <input type="text" name="number" value="{{ $user->addresses->first() ? $user->addresses->first()->number : '' }}" id="number" placeholder="Nº" class="form-field">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 50%;">
                                        <label for="complement" class="label">Complemento</label>

                                        <div class="control">
                                            <input type="text" name="complement" value="{{ $user->addresses->first() ? $user->addresses->first()->complement : '' }}" id="complement" class="form-field" placeholder="Apto, bloco... (opcional)">
                                        </div>
                                    </div>

                                    <div class="field" style="flex-basis: 50%;">
                                        <label for="district" class="label">Bairro</label>

                                        <div class="control">
                                            <select name="district_id" id="district" class="form-field">
                                                <option value="" selected disabled>Bairro da entrega</option>

                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}" @if ($user->addresses->first() && $user->addresses->first()->district_id == $district->id) selected @endif>{{ $district->name }}</option>
                                                @endforeach
                                            </select>
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
