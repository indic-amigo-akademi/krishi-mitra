@extends('layouts.app')

@section('content')

    <div class="uk-width-1-1 uk-height-1-1 uk-background-cover uk-background-norepeat uk-padding-small"
        style="background-image:url({{ asset('images/background/img7.jpg') }})">

        <div class="uk-card uk-container uk-card-default">
            <div class="uk-card-header">
                <h3 class="uk-card-title">User Dashboard</h3>
            </div>
            <div class="uk-card-body">
                <ul class="uk-list links">
                    <li><a href="{{ route('profile') }}">My Profile</a></li>
                    <li><a href="{{ route('cart') }}">My Cart</a></li>
                    <li><a href="{{ route('orders') }}">My Orders</a></li>
                    @if (Auth::user()->is_seller || Auth::user()->role=='customer')
                        <li><a href="{{ route('address') }}">Manage Address</a></li>
                    @endif
                    @if (!(Auth::user()->is_admin || Auth::user()->is_seller))
                        <li><a href="{{ route('seller.register') }}">Register as Seller</a></li>
                    @endif
                </ul>
            </div>
            <div class="uk-card-footer"></div>
        </div>
    </div>
@endsection
