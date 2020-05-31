<footer>
    <div class="container full-width">
        <div class="columns">
            <div class="column is-4 is-offset-2">
                <div class="columns">
                    <div class="column is-12">
                        <a href="{{ route('home') }}" class="logo-nosuper">
                            <img src="{{ asset('images/logo-nosuper.png') }}">
                        </a>

                        <hr class="line">
                    </div>
                </div>

                <div class="columns links">
                    <div class="column is-4">
                        <ul>
                            <li><a href="{{ route('user.login') }}">Entrar</a></li>
                            <li><a href="{{ route('user.register') }}">Cadastrar</a></li>
                            <li><a href="#" class="show-modal" data-type="contact">Atendimento</a></li>
                        </ul>
                    </div>

                    <div class="column is-4">
                        <ul>
                            <li><a href="{{ route('user.data') }}">Minha conta</a></li>
                            <li><a href="{{ route('user.orders') }}">Meus pedidos</a></li>
                            <!-- <li><a href="">Itens salvos</a></li> -->
                        </ul>
                    </div>

                    <div class="column is-4">
                        <ul>
                            <li><a href="{{ route('terms.use') }}">Termos de uso</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacidade</a></li>
                            <li><a href="#" class="show-modal" data-type="rules">Regras de uso</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="column is-5 is-offset-1">
                <div class="content">
                    <img src="{{ asset('images/safe-site.png') }}" class="safe-site">

                    <div class="social">
                        <a href="#" class="facebook" target="_blank"></a>
                        <a href="#" class="instagram" target="_blank"></a>
                        <a href="#" class="twitter" target="_blank"></a>
                        <a href="#" class="youtube" target="_blank"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column s-12 pb-0">
                <div class="copyright">
                    <p>
                        Copyright 2020. Todos os direitos reservados.<br>
                        Dogs Are Awesome Atividades de Internet Ltda - CNPJ 32.194.554/0001-63
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-contact">
        <div class="modal-background"></div>
        <div class="modal-card">
            <div class="modal-card-head">
                <img src="{{ asset('images/icon-mail.png') }}" alt="Atendimento" class="modal-icon">
                <h2 class="modal-title">Atendimento</h2>
                <h3 class="modal-subtitle">Respondemos em até 1 dia útil</h3>
            </div>

            <div class="modal-card-body">
                <form method="POST" action="{{ route('contact-send') }}" id="form-contact">
                    @csrf

                    <div class="item">
                        <span>E-mail</span>
                        contato@nosuper.com.br
                    </div>

                    <div class="item">
                        <span>WhatsApp</span>
                        (53) 9 9123-5698
                    </div>

                    <div class="item">
                        <span>Mensagem</span>

                        <input type="text" name="name" placeholder="Nome">

                        <input type="email" name="email" placeholder="E-mail">

                        <textarea name="message" placeholder="Mensagem"></textarea>

                        <button type="submit">ENVIAR</button>
                    </div>
                </form>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>

    <div class="modal modal-rules">
        <div class="modal-background"></div>
        <div class="modal-card">
            <div class="modal-card-head">
                <img src="{{ asset('images/icon-info.png') }}" alt="Regras de uso" class="modal-icon">
                <h2 class="modal-title">Regras de uso</h2>
                <h3 class="modal-subtitle">Observe as regras antes de fazer um pedido</h3>
            </div>

            <div class="modal-card-body">
                <div class="navigation">
                    <button type="buttonn" data-type="buy" class="active">Compra</button>
                    <button type="button" data-type="delivery">Entrega</button>
                    <button type="button" data-type="exchange">Troca</button>
                </div>

                <div class="text text-buy active">
                    <p>
                        <span>● É proibida a venda de produtos alcoólicos para menores de idade, caso o seu pedido tenha algum produto alcoólico, será necessário a presença de um adulto no momento da entrega.</span>
                        <span>● Os pedidos pagos com cartão de crédito ou cartão de débito só terão a compra processada no dia da entrega.</span>
                        <span>● O valor total da sua compra poderá sofrer uma variação de até 20%, para mais ou para menos, devido aos produtos de peso variável que serão pesados somente no momento da separação.</span>
                        <span>● Reservamo-nos o direito de limitar a quantidade de produtos vendidos a cada cliente.</span>
                        <span>● A compra está sujeita à disponibilidade dos itens em estoque no dia da entrega.</span>
                        <span>● Os preços, ofertas e condições de pagamento podem sofrer alterações sem aviso prévio.</span>
                        <span>● As imagens dos produtos são meramente ilustrativas.</span>
                    </p>
                </div>

                <div class="text text-delivery">
                    <p>
                        <span>● Realizamos as entregas de segunda à sábado entre 08:00 e 20:00, não entregamos nos domingos e feriados.</span>
                        <span>● Você poderá escolher o melhor dia e horário para receber suas compras, mas após finalizar o pedido não poderá alterar o agendamento.</span>
                        <span>● Caso não seja possível selecionar algum dia e/ou horário de entrega é porque o mesmo já atingiu o seu limite máximo de entregas.</span>
                        <span>● É necessário a presença de uma pessoa autorizada no local da entrega para receber o pedido e assinar o comprovante de recebimento.</span>
                        <span>● Se não houver a presença de um(a) responsável no momento da entrega, será realizada uma nova tentativa à combinar, e caso aconteça novamente o pedido será cancelado.</span>
                    </p>
                </div>

                <div class="text text-exchange">
                    <p>
                        <span>● Você poderá realizar a troca ou devolução de itens se no momento da entrega você verificar algum problema em relação ao seu pedido.</span>
                        <span>● Os motivos aceitos para a troca ou devolução são: itens diferentes em teor ou quantidade do solicitado, itens danificados ou itens vencidos.</span>
                        <span>● Para realizar a troca ou devolução entre em contato com a nossa central de atendimento para dar início ao processo.</span>
                        <span>● A troca ou devolução poderá ser feita diretamente no supermercado, basta levar o produto e a nota fiscal do mesmo para realizar o processo.</span>
                        <span>● Não será aceita a troca ou devolução de itens com a embalagem violada.</span>
                        <span>● O cancelamento de pedidos pode ser feito diretamente na sua conta da plataforma e caso o pedido já tenha sido enviado, o cliente deverá recusar o recebimento no momento da entrega.</span>
                        <span>● No caso de cancelamentos onde o pagamento já tiver sido efetuado, o valor do pedido será restituído no cartão utilizado na compra, descontado o valor do frete e da separação dos itens.</span>
                    </p>
                </div>
            </div>

            <div class="modal-card-foot">
                <p class="text">Em caso de dúvidas entre em contato como a nossa central de atendimento.</p>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>

    @if (isset($market))
        <div class="modal modal-payment">
            <div class="modal-background"></div>
            <div class="modal-card">
                <div class="modal-card-head">
                    <img src="{{ asset('images/icon-card.png') }}" alt="Formas de pagamento" class="modal-icon">
                    <h2 class="modal-title">Formas de pagamento</h2>
                    <h3 class="modal-subtitle">{{ $market->name }}</h3>
                </div>

                <div class="modal-card-body">
                    @foreach ($market->payments as $payment)
                        @if (isset($type) && $type != $payment->type)
                            <span class="payment-type">
                                @if ($payment->type == 2)
                                    Cartão de débito
                                @elseif ($payment->type == 3)
                                    Cartão de crédito
                                @endif
                            </span>
                        @endif
                        @php $type = $payment->type; @endphp

                        <span class="{{ $payment->type == 1 ? 'payment-type' : 'payment-name' }}">{{ $payment->name }}</span>
                    @endforeach
                </div>

                <div class="modal-card-foot">
                    <p class="text">Você realizará o pagamento somente ao receber suas compras.</p>
                </div>
            </div>

            <button class="modal-close is-large" aria-label="close"></button>
        </div>

        <div class="modal modal-freight">
            <div class="modal-background"></div>
            <div class="modal-card">
                <div class="modal-card-head">
                    <img src="{{ asset('images/icon-truck.png') }}" alt="Valores da entrega" class="modal-icon">
                    <h2 class="modal-title">Valores da entrega</h2>
                    <h3 class="modal-subtitle">{{ $market->name }}</h3>
                </div>

                <div class="modal-card-body">
                    @foreach ($market->freights as $freight)
                        <div class="freight">
                            <span class="freight-name">{{ $freight->name }}</span>
                            <span class="freight-price">R$ {{ _formatDolarToReal($freight->pivot->price) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="modal-card-foot">
                    <p class="text">Além do valor da entrega também é cobrado uma taxa de separação dos produtos no valor de R5,00 por pedido.</p>
                </div>
            </div>

            <button class="modal-close is-large" aria-label="close"></button>
        </div>
    @endif
</footer>
