@extends('layouts.app')

@section('content')

    <div class="uk-width-1-1 uk-height-1-1 uk-background-cover uk-background-norepeat uk-padding-small" style="background-image:url({{ asset('images/background/img7.jpg') }})">

        <div class="uk-card uk-container uk-card-default">
            <div class="uk-card-header">
                <h3 class="uk-card-title">Seller Dashboard</h3>
            </div>
            <div class="uk-card-body">
                <ul class="uk-list links">
                    <li><a href="{{ route('product.create') }}">Add your product</a></li>
                    <li><a href="{{ route('product.browse') }}">Browse products</a></li>
                </ul>
            </div>
            <div class="uk-card-footer"></div>
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
