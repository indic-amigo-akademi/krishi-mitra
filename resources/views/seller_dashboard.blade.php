@extends('layouts.app')

@section('content')
    <form action="/admin_dashboard" method="GET">

        <div class="uk-height-1-1 sboard" style="background-image:url({{ asset('images/background/img7.jpg') }})">

            <div class="uk-height-1-1 uk-padding-large sboard-bg">
                <div class="uk-heading-medium uk-text-bold uk-text-center sboard-heading uk-margin-large">Welcome To Seller
                    Dashboard</div>
                <div class="uk-width-1-1 uk-flex uk-flex-center uk-margin">
                    <a href="/products" class="uk-padding-small uk-text-bold uk-margin-right sboard-btn">Browse products</a>
                    <a href="/create_product" class="uk-padding-small uk-text-bold uk-margin-left sboard-btn">Sell your
                        produces</a>
                </div>

            </div>
        </div>
    </form>
@endsection
