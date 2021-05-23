@extends('layouts.app')

@section('content')

    <div class="uk-height-1-1 sboard" style="background-image:url({{ asset('images/background/img7.jpg') }})">

        <div class="uk-height-1-1 uk-padding-large sboard-bg">
            <div class="uk-heading-medium uk-text-bold uk-text-center sboard-heading uk-margin-large">Welcome To Seller
                Dashboard</div>
            <div class="uk-width-1-1 uk-flex uk-flex-center uk-margin">
                <a href="{{ route('product.browse') }}"
                    class="uk-padding-small uk-text-bold uk-margin-right sboard-btn">Browse products</a>
                <a href="{{ route('product.create') }}"
                    class="uk-padding-small uk-text-bold uk-margin-left sboard-btn">Sell your
                    produces</a>
            </div>

        </div>
    </div>
    {{-- <div class="uk-container">
        <div class="uk-card" uk-card-default>
            <div class="uk-card-header">
                <h3 class="uk-card-title">Seller Dashboard</h3>
            </div>
            <div class="uk-card-body">
                <ul class="uk-list links">
                    <li><a href="{{ route('product.create') }}">Sell your produces</a></li>
                    <li><a href="{{ route('product.browse') }}">Browse products</a></li>
                </ul>
            </div>
            <div class="uk-card-footer"></div>
        </div>
    </div> --}}

@endsection
