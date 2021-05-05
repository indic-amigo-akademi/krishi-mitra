@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Krishi-Mitra
            </div>

            <div class="links">
                <a href="https://laravel.com/docs">Register as Seller</a>
                <a href="https://laracasts.com">Browse products</a>
                <a href="https://laravel-news.com">Sell your produces</a>
                <a href="https://blog.laravel.com">Talk to farmers</a>
            </div>
        </div>
    </div>
@endsection
