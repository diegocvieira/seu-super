@php
    $hide_btn_finish = true;
    $hideHeaderMenu = true;
@endphp

@extends ('app')

@section('content')
    @include ('inc._header')

    <div class="page page-cart-finish">
        <div class="container full-width">
            <form action="{{ route('order-save') }}" method="POST" id="form-cart-finish">
                @csrf

                <input type="hidden" name="market_id" value="{{ $market->id }}" />
                <input type="hidden" name="unavailable_dates" value="{{ implode(';', $unavailableDates) }}" />

                <div class="columns">
                    <div class="column is-3">
                        <div class="finish">
                            <div class="section">
                                <button type="submit" class="btn-submit" disabled autocomplete="off">Finalizar pedido</button>

                                <p class="text-top">Preencha todos os dados para a entrega</p>
                            </div>

                            <div class="section price">
                                <span>Subtotal</span>
                                <span class="subtotal-price">R${{ _formatDolarToReal($cartProducts['total']) }}</span>

                                <span>Taxa de separação</span>
                                <span class="separation-price">R${{ _formatDolarToReal(_separationPrice()) }}</span>

                                <span>Entrega</span>
                                <span class="freight-price">{{ $freightPrice ? 'R$' . _formatDolarToReal($freightPrice) : '----------' }}</span>
                            </div>

                            <div class="section line price total">
                                <span>Total</span>
                                <span class="total-price">{{ $totalPrice ? 'R$' . _formatDolarToReal($totalPrice) : '----------' }}</span>
                            </div>

                            <div class="section line">
                                <div class="market">
                                    <img src="{{ asset('storage/uploads/markets/' . $market->logo_image) }}" alt="{{ $market->name }}" class="market-image">
                                    <h3 class="market-name">{{ $market->name }}</h3>
                                </div>

                                <p class="contact">
                                    <span>Precisa de ajuda?</span>
                                    <a href="" class="show-modal" data-type="contact">Acesse aqui</a> para falar com um de nossos atendentes
                                </p>
                            </div>

                            <div class="section line">
                                <p class="text-bottom">
                                    Ao fazer o pedido você confirma que leu e concorda com os termos de uso, as políticas de privacidade e as regras de uso.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="data">
                            <div class="data-header">
                                <h2 class="data-title">Dados para a entrega</h2>

                                <p class="data-subtitle">Preencha todos os campos corretamente</p>
                            </div>

                            <section class="section personal {{ $user->checkRequiredPersonalOrderFields() ? 'section-validate' : '' }}">
                                <div class="header-section">
                                    <div class="content">
                                        <h3 class="section-title">Seus dados</h3>
                                        <p class="preview">
                                            @if ($user->checkRequiredPersonalOrderFields())
                                                {{ $user->name }} - {{ _formatCellphone($user->cellphone) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="fields-container">
                                    <div class="fields">
                                        <h4 class="fields-title">Dados pessoais</h4>

                                        <div class="group">
                                            <div class="field">
                                                <label for="name" class="label">Nome</label>

                                                <div class="control">
                                                    <input type="text" name="name" value="{{ $user->name }}" id="name" placeholder="Nome completo" class="form-field">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label for="email" class="label">E-mail</label>

                                                <div class="control">
                                                    <input type="text" name="email" value="{{ $user->email }}" id="email" placeholder="Seu e-mail" class="form-field">
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

                                    <div class="fields">
                                        <h4 class="fields-title">Contato</h4>

                                        <div class="group">
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

                                    <div class="fields">
                                        <h4 class="fields-title">Documentos</h4>

                                        <div class="group">
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
                                </div>
                            </section>

                            <section class="section address {{ $user->checkRequiredAddressOrderFields($user->addresses->first()) ? 'section-validate' : '' }}">
                                <div class="header-section">
                                    <div class="content">
                                        <h3 class="section-title">Endereço de entrega</h3>
                                        <p class="preview">
                                            @if ($user->checkRequiredAddressOrderFields($user->addresses->first()))
                                                {{ $user->addresses->first()->street }}, {{ $user->addresses->first()->number }}
                                                @if ($user->addresses->first()->complement)
                                                    - {{ $user->addresses->first()->complement }}
                                                @endif
                                                - {{ $user->addresses->first()->district->name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="fields-container">
                                    <div class="fields">
                                        <h4 class="fields-title">Endereço</h4>

                                        <div class="group">
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
                                </div>
                            </section>

                            <section class="section delivery-date">
                                <div class="header-section">
                                    <div class="content">
                                        <h3 class="section-title">Agendar entrega</h3>
                                        <p class="preview"></p>
                                    </div>
                                </div>

                                <div class="fields-container">
                                    <div class="fields">
                                        <h4 class="fields-title">Quando deseja receber?</h4>

                                        <div class="group">
                                            <div class="field">
                                                <label for="delivery_date" class="label">Data da entrega</label>

                                                <div class="control">
                                                    <input type="text" name="delivery_date" id="delivery_date" class="is-hidden form-field" autocomplete="off">
                                                    <div id="datepicker"></div>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label for="delivery_hour" class="label">Horário da entrega</label>

                                                <div class="control">
                                                    <input type="radio" name="delivery_hour" value="Entre 08:00 e 12:00" id="delivery_hour1" class="is-hidden radio-field form-field" autocomplete="off">
                                                    <label for="delivery_hour1" class="radio-label">Entre 08:00 e 12:00</label>

                                                    <input type="radio" name="delivery_hour" value="Entre 12:00 e 16:00" id="delivery_hour2" class="is-hidden radio-field form-field" autocomplete="off">
                                                    <label for="delivery_hour2" class="radio-label">Entre 12:00 e 16:00</label>

                                                    <input type="radio" name="delivery_hour" value="Entre 16:00 e 20:00" id="delivery_hour3" class="is-hidden radio-field form-field" autocomplete="off">
                                                    <label for="delivery_hour3" class="radio-label">Entre 16:00 e 20:00</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="section instructions">
                                <div class="header-section">
                                    <div class="content">
                                        <h3 class="section-title">Instruções</h3>
                                        <p class="preview"></p>
                                    </div>
                                </div>

                                <div class="fields-container">
                                    <div class="fields">
                                        <h4 class="fields-title">Algum pedido especial?</h4>

                                        <div class="group">
                                            <div class="field">
                                                <label for="" class="label">O que fazer se algum item estiver em falta?</label>

                                                <div class="control">
                                                    <input type="radio" name="products_missing" value="Substituir pelo mais similar" id="products_missing1" class="is-hidden radio-field form-field" autocomplete="off">
                                                    <label for="products_missing1" class="radio-label">Substituir pelo mais similar</label>

                                                    <input type="radio" name="products_missing" value="Retirar o item da lista" id="products_missing2" class="is-hidden radio-field form-field" autocomplete="off">
                                                    <label for="products_missing2" class="radio-label">Retirar o item da lista</label>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label for="instructions" class="label">Instrução para o entregador</label>

                                                <div class="control">
                                                    <textarea name="instructions" id="instructions" placeholder="Por favor, deixe as compras na portaria do prédio... (opcional)" class="form-field" autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="section payment">
                                <div class="header-section">
                                    <div class="content">
                                        <h3 class="section-title">Forma de pagamento</h3>
                                        <p class="preview"></p>
                                    </div>
                                </div>

                                <div class="fields-container">
                                    <div class="fields">
                                        <h4 class="fields-title">Como irá fazer o pagamento?</h4>

                                        <div class="group">
                                            <div class="field">
                                                <label class="label">Selecione a forma de pagamento</label>

                                                <div class="control">
                                                    <input type="radio" name="payment_money" value="{{ $market->payments->where('type', 1)->first()->name }}" id="payment-money" class="form-field is-hidden" autocomplete="off" />

                                                    @foreach ($market->payments as $payment)
                                                        @if (!isset($type) || isset($type) && $type != $payment->type)
                                                            <input type="radio" name="payment_type" value="{{ $payment->type }}" id="payment-type{{ $payment->type }}" class="payment-type form-field is-hidden" autocomplete="off" />
                                                            <label for="payment-type{{ $payment->type }}" class="radio-label">
                                                                @if ($payment->type == 2)
                                                                    Cartão de débito
                                                                @elseif ($payment->type == 3)
                                                                    Cartão de crédito
                                                                @else
                                                                    Dinheiro
                                                                @endif
                                                            </label>
                                                        @endif
                                                        @php $type = $payment->type; @endphp
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="field payment-type-field payment-type1 is-hidden">
                                                <label for="money-change" class="label">Troco para quanto?</label>

                                                <div class="control">
                                                    <input type="text" name="money_change" id="money-change" placeholder="Valor em reais (opcional)" autocomplete="off" class="form-field mask-money">
                                                </div>
                                            </div>

                                            <div class="field payment-type-field payment-type2 is-hidden">
                                                <label for="payment-card-debit" class="label">Bandeira do cartão</label>

                                                <div class="control">
                                                    <select name="payment_debit" id="payment-card-debit" autocomplete="off" class="form-field">
                                                        <option value="" disabled selected>Selecione</option>
                                                        @foreach ($market->payments->where('type', 2) as $payment)
                                                            <option value="Cartão de débito {{ $payment->name }}">{{ $payment->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="field payment-type-field payment-type3 is-hidden">
                                                <label for="payment-card-credit" class="label">Bandeira do cartão</label>

                                                <div class="control">
                                                    <select name="payment_credit" id="payment-card-credit" autocomplete="off" class="form-field">
                                                        <option value="" disabled selected>Selecione</option>
                                                        @foreach ($market->payments->where('type', 3) as $payment)
                                                            <option value="Cartão de crédito {{ $payment->name }}">{{ $payment->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="column is-3">
                        @include ('inc._cart')
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include ('inc._footer')
@endsection
