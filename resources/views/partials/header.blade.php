<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<nav class="upper-navbar">
    <div class="left-content">
        <img class="logo" src="{{ asset('images/icons/logo.png') }}" />
        <p>Krishi-Mitra</p>
    </div>

    <div class="uk-navbar-left center-content">
        <div class="uk-navbar-item">
            <form class="uk-search uk-search-navbar uk-text-bold uk-text-italic">
                <span uk-search-icon></span>
                <input class="uk-search-input" type="search" placeholder="Search">
            </form>
        </div>
    </div>

    <div class="right-content">
        <div class="nav-link" uk-toggle="target: #signin-form"><i
                class="fa fa-user"></i><span>{{ __('Login') }}</span></div>
        <button class="nav-link" uk-toggle="target: #signup-form"><span>{{ __('Register') }}</span></button>
        <div class="nav-link"><i class="fa fa-opencart"></i><span>Cart</span></div>
    </div>
</nav>

<div class="header-content"
    style="background-image:url({{ asset('images/background/img1.jpg') }}); filter:sepia(20%);">
    <nav class="upper-content">
        <a>Home</a>
        <a>Explore</a>
        <a>My Orders</a>
        <a>Sell on Krishi-Mitra</a>
        <a>Contact us</a>
    </nav>
</div>


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
