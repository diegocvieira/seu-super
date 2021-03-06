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
                <h3 class="modal-subtitle">Respondemos em at?? 1 dia ??til</h3>
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
                        <span>??? ?? proibida a venda de produtos alco??licos para menores de idade, caso o seu pedido tenha algum produto alco??lico, ser?? necess??rio a presen??a de um adulto no momento da entrega.</span>
                        <span>??? Os pedidos pagos com cart??o de cr??dito ou cart??o de d??bito s?? ter??o a compra processada no dia da entrega.</span>
                        <span>??? O valor total da sua compra poder?? sofrer uma varia????o de at?? 20%, para mais ou para menos, devido aos produtos de peso vari??vel que ser??o pesados somente no momento da separa????o.</span>
                        <span>??? Reservamo-nos o direito de limitar a quantidade de produtos vendidos a cada cliente.</span>
                        <span>??? A compra est?? sujeita ?? disponibilidade dos itens em estoque no dia da entrega.</span>
                        <span>??? Os pre??os, ofertas e condi????es de pagamento podem sofrer altera????es sem aviso pr??vio.</span>
                        <span>??? As imagens dos produtos s??o meramente ilustrativas.</span>
                    </p>
                </div>

                <div class="text text-delivery">
                    <p>
                        <span>??? Realizamos as entregas de segunda ?? s??bado entre 08:00 e 20:00, n??o entregamos nos domingos e feriados.</span>
                        <span>??? Voc?? poder?? escolher o melhor dia e hor??rio para receber suas compras, mas ap??s finalizar o pedido n??o poder?? alterar o agendamento.</span>
                        <span>??? Caso n??o seja poss??vel selecionar algum dia e/ou hor??rio de entrega ?? porque o mesmo j?? atingiu o seu limite m??ximo de entregas.</span>
                        <span>??? ?? necess??rio a presen??a de uma pessoa autorizada no local da entrega para receber o pedido e assinar o comprovante de recebimento.</span>
                        <span>??? Se n??o houver a presen??a de um(a) respons??vel no momento da entrega, ser?? realizada uma nova tentativa ?? combinar, e caso aconte??a novamente o pedido ser?? cancelado.</span>
                    </p>
                </div>

                <div class="text text-exchange">
                    <p>
                        <span>??? Voc?? poder?? realizar a troca ou devolu????o de itens se no momento da entrega voc?? verificar algum problema em rela????o ao seu pedido.</span>
                        <span>??? Os motivos aceitos para a troca ou devolu????o s??o: itens diferentes em teor ou quantidade do solicitado, itens danificados ou itens vencidos.</span>
                        <span>??? Para realizar a troca ou devolu????o entre em contato com a nossa central de atendimento para dar in??cio ao processo.</span>
                        <span>??? A troca ou devolu????o poder?? ser feita diretamente no supermercado, basta levar o produto e a nota fiscal do mesmo para realizar o processo.</span>
                        <span>??? N??o ser?? aceita a troca ou devolu????o de itens com a embalagem violada.</span>
                        <span>??? O cancelamento de pedidos pode ser feito diretamente na sua conta da plataforma e caso o pedido j?? tenha sido enviado, o cliente dever?? recusar o recebimento no momento da entrega.</span>
                        <span>??? No caso de cancelamentos onde o pagamento j?? tiver sido efetuado, o valor do pedido ser?? restitu??do no cart??o utilizado na compra, descontado o valor do frete e da separa????o dos itens.</span>
                    </p>
                </div>
            </div>

            <div class="modal-card-foot">
                <p class="text">Em caso de d??vidas entre em contato como a nossa central de atendimento.</p>
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
                                    Cart??o de d??bito
                                @elseif ($payment->type == 3)
                                    Cart??o de cr??dito
                                @endif
                            </span>
                        @endif
                        @php $type = $payment->type; @endphp

                        <span class="{{ $payment->type == 1 ? 'payment-type' : 'payment-name' }}">{{ $payment->name }}</span>
                    @endforeach
                </div>

                <div class="modal-card-foot">
                    <p class="text">Voc?? realizar?? o pagamento somente ao receber suas compras.</p>
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
                    <p class="text">Al??m do valor da entrega tamb??m ?? cobrado uma taxa de separa????o dos produtos no valor de R5,00 por pedido.</p>
                </div>
            </div>

            <button class="modal-close is-large" aria-label="close"></button>
        </div>
    @endif
</footer>
