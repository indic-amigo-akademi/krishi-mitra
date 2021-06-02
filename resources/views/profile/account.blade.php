@extends('layouts.app')


@section('content')

    <div class="uk-width-1-1 uk-height-1-1 uk-background-cover uk-background-norepeat uk-padding-small"
        style="background-image:url({{ asset('images/background/img7.jpg') }})">

        <div class="uk-card uk-container uk-card-default">
            <div class="uk-card-header">
                <h3 class="uk-card-title">My Profile</h3>
            </div>

            <div class="uk-card-body">
                <h4>User Info: </h4>
                <p>
                    <b>Name:</b> {{ Auth::user()->name }}<br>
                    <b>Username:</b> {{ Auth::user()->username }}<br>
                    <b>Registered Email:</b> {{ Auth::user()->email }}<br>
                    <b>Registered Phone Number:</b> {{ Auth::user()->phone }}<br>
                </p>

                @if (Auth::user()->is_seller)
                    <h4>Seller Info: </h4>
                    <p>
                        <b>Name:</b> {{ Auth::user()->seller->name }}<br>
                        <b>Tradename:</b> {{ Auth::user()->seller->trade_name }}<br>
                        <b>GSTIN:</b> {{ Auth::user()->seller->gstin ?? 'Not a Registered GST Seller'}}<br>
                        <b>Aadhar Number:</b> {{ Auth::user()->seller->aadhaar }}<br>
                    </p>
                @endif
            </div>



        </div>
    </div>

@endsection
