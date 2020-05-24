<div class="navigation">
    <ul>
        <li>
            <a href="{{ route('user.data') }}" class="{{ $navigation == 'data' ? 'active' : '' }}">Meus dados</a>
        </li>

        <li>
            <a href="{{ route('user.orders') }}" class="{{ $navigation == 'orders' ? 'active' : '' }}">Meus pedidos</a>
        </li>

        <li>
            <a href="{{ route('user.addresses') }}" class="{{ $navigation == 'addresses' ? 'active' : '' }}">Meu endereço</a>
        </li>

        <li>
            <a href="#" class="show-modal" data-type="contact">Atendimento</a>
        </li>

        <li>
            <a href="{{ route('user.access') }}" class="{{ $navigation == 'access' ? 'active' : '' }}">Acesso</a>
        </li>

        <li>
            <a href="{{ route('user.delete.account') }}" class="open-modal-delete-account">Deletar conta</a>
        </li>

        <li>
            <a href="{{ route('user.logout') }}">Sair</a>
        </li>
    </ul>
</div>
