@if (!isset($hideHeaderMenu))
    <nav>
        <ul>
            @if (Auth::guard('nosuper')->check())
                <li class="logged">
                    <button type="button" class="open-menu">{{ _getFirstWord(Auth::guard('nosuper')->user()->name) }}</button>

                    <ul class="dropdown">
                        <li>
                            <a href="{{ route('nosuper.index') }}" class="icon-account">Dashboard</a>
                        </li>

                        <li>
                            <a href="{{ route('nosuper.logout') }}" class="icon-logout">Sair</a>
                        </li>
                    </ul>
                </li>
            @elseif (Auth::check())
                <li class="logged">
                    <button type="button" class="open-menu">{{ _getFirstWord(Auth::user()->name) }}</button>

                    <ul class="dropdown">
                        <li>
                            <a href="{{ route('user.data') }}" class="icon-account">Minha conta</a>
                        </li>

                        <li>
                            <a href="{{ route('user.orders') }}" class="icon-orders">Meus pedidos</a>
                        </li>

                        <!-- <li>
                            <a href="" class="icon-saved-items">Itens salvos</a>
                        </li> -->

                        <li>
                            <a href="" class="icon-contact show-modal" data-type="contact">Atendimento</a>
                        </li>

                        <li>
                            <a href="{{ route('user.logout') }}" class="icon-logout">Sair</a>
                        </li>
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{ route('user.register') }}">Cadastrar</a>
                </li>

                <li>
                    <a href="{{ route('user.login') }}">Entrar</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
