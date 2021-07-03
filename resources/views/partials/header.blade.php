<nav class="uk-navbar-container  upper-navbar" uk-navbar>
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
                <li class="nav-link user-navbar-btn uk-position-relative uk-position-z-index">
                    <a href="#">
                        <span uk-icon="user"></span>
                        <span class="icon-text uk-text-truncate">{{ Auth::user()->username }}</span>
                    </a>
                    <div class="uk-navbar-dropdown" uk-dropdown="mode: click">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li>
                                <a href="{{ route('customer.index') }}">
                                    <span class="icon ri-settings-fill"></span>
                                    <span class="text-icon">Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="document.getElementById('logoutFrm').submit()">
                                    <form id="logoutFrm" action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <span class="icon ri-logout-circle-fill"></span>
                                        <span class="text-icon">Logout</span>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="uk-navbar-item nav-link">
                    <span uk-icon="cart"></span>
                    <a href="{{ route('cart') }}" class="icon-text">{{ __('Cart') }}</a>
                </li>
            @else
                <li class="uk-padding-remove nav-link" uk-toggle="target: #signin-form">
                    <a href="#" class="text-icon">
                        <small>{{ __('Login') }}</small>
                    </a>
                </li>
                <li class="uk-padding-remove nav-link" uk-toggle="target: #signup-form">
                    <a href="#" class="text-icon">
                        <small>{{ __('Register') }}</small>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="nav-overlay uk-navbar-left center-content" hidden>
        <div class="uk-navbar-item search">
            <form class="uk-search uk-search-navbar uk-text-bold uk-text-italic" action="{{ route('explore') }}"
                id="searchForm">
                <div class="uk-inline">
                    <a href="#" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"
                        onclick="searchFormSubmit(event)"></a>
                    <input class="uk-input uk-search-input" type="search" placeholder="Search..." autofocus name="q" />
                </div>
            </form>
            <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade"
                href="#"></a>
        </div>
    </div>

</nav>

<nav class="uk-navbar-container lower-navbar" uk-navbar>
    <ul class="uk-navbar-nav uk-navbar-center">
        <li class="uk-navbar-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="uk-navbar-item"><a href="{{ route('explore') }}">Explore</a></li>
        @if (Auth::check())
            <li class="uk-navbar-item"><a href="{{ route('orders') }}">My Orders</a></li>
        @endif
        @if (Auth::check() && Auth::user()->is_seller)
            <li class="uk-navbar-item"><a href="{{ route('seller.index') }}">Seller Dashboard</a></li>
        @elseif(Auth::check() && Auth::user()->is_admin)
            <li class="uk-navbar-item"><a href="{{ route('admin.index') }}">Admin Dashboard</a></li>
        @else
            <li class="uk-navbar-item"><a href="{{ route('seller.register') }}">Sell on Krishi-Mitra</a></li>
        @endif

    </ul>
</nav>


@include('partials.forms.registerForm')
@include('partials.forms.loginForm')
