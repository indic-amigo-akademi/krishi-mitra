<nav class="uk-navbar-container upper-navbar" uk-navbar>
    <div class="nav-overlay uk-navbar-left left-content">
        <div class="navbar-toggle uk-navbar-toggle" uk-navbar-toggle-icon uk-toggle="target: .lower-navbar"></div>
        <a class="uk-navbar-item uk-logo" href="#">
            <img class="logo" src="{{ asset('images/icons/logo.png') }}" alt="logo text" />
            <span class="logo-text font-cursive">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <a class="uk-navbar-toggle" uk-search-icon uk-toggle="target: .nav-overlay; animation: uk-animation-fade"
            href="#"></a>
    </div>

    <div class="nav-overlay uk-navbar-right right-content">
        <ul class="uk-navbar-nav">
            @if (Auth::check())
                <li class="uk-navbar-item nav-link user-navbar-btn">
                    <a href="#">
                        <span class="icon ri-user-fill ri-1g"></span>
                        <span class="icon-text uk-text-truncate">{{ Auth::user()->username }}</span>
                    </a>
                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li>
                                <a href="#">
                                    <span class="icon ri-settings-fill ri-1g"></span>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="document.getElementById('logoutFrm').submit()">
                                    <form id="logoutFrm" action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <span class="icon ri-logout-circle-fill ri-1g"></span>
                                        <span>Logout</span>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="uk-navbar-item nav-link">
                    <span class="icon ri-shopping-cart-fill"></span>
                    <a href="#" class="icon-text">{{ __('Cart') }}</a>
                </li>
            @else
                <li class="uk-navbar-item nav-link" uk-toggle="target: #signin-form">
                    <a href="#" class="text-icon">
                        <small>{{ __('Login') }}</small>
                    </a>
                </li>
                <li class="uk-navbar-item nav-link" uk-toggle="target: #signup-form">
                    <a href="#" class="text-icon">
                        <small>{{ __('Register') }}</small>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="nav-overlay uk-navbar-left center-content" hidden>
        <div class="uk-navbar-item search">
            <form class="uk-search uk-search-navbar uk-text-bold uk-text-italic">
                <input class="uk-search-input" type="search" placeholder="Search..." autofocus />
            </form>
            <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade"
                href="#"></a>
        </div>
    </div>

</nav>

<nav class="uk-navbar-container lower-navbar" uk-navbar>
    <ul class="uk-navbar-nav uk-navbar-center">
        <li class="uk-navbar-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="uk-navbar-item"><a href="{{ route('welcome') }}">Explore</a></li>
        <li class="uk-navbar-item"><a href="">My Orders</a></li>
        <li class="uk-navbar-item"><a href="">Sell on Krishi-Mitra</a></li>
        <li class="uk-navbar-item"><a href="{{ route('contact') }}">Contact us</a></li>
    </ul>
</nav>


@include('partials.forms.registerForm')
@include('partials.forms.loginForm')


{{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        {{-- <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a class="nav-link" uk-toggle="target: #signin-form">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            {{-- - <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            <a class="nav-link" uk-toggle="target: #signup-form">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> --}}
