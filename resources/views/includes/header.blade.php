<header class="header">
    <div class="header__logo">
        <a href="{{ route('main.index') }}"><img src="{{ asset('assets/images/FAUX_small.png') }}" alt="logo"></a>
        <span>FAUX ED</span>
    </div>

    <input name="burger_menu" type="checkbox" id="burger_menu">
    <label for="burger_menu"></label>
    <nav class="header__menu">
        <ul>
            @auth
                @if($page !== 'admin' && $page !== 'swagger')
                <li><a href="{{ route('admin.faux.index') }}" class="home">Students</a></li>
                @endif

                <li>
                    <form action="{{ route('auth.logout') }}" method="post">
                        @csrf

                        <input type="submit" value="Logout" />
                    </form>
                </li>
            @else
                @if($page !== 'login' && $page !== 'swagger')
                <li><a href="{{ route('auth.login') }}">Login</a></li>
                @endif

                @if($page !== 'register' && $page !== 'swagger')
                <li><a href="{{ route('auth.register') }}">Register</a></li>
                @endif
            @endauth
        </ul>
    </nav>
</header>
