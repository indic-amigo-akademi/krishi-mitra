@extends('layouts.app')

@section('content')
    <div class="uk-width-1-1 uk-height-1-1 uk-background-cover uk-background-norepeat"
        style="background-image:url({{ asset('images/background/img3.jpg') }})">
        <form action="{{ route('seller.create') }}" method="POST">
            @csrf
            <div class="uk-padding-large uk-text-large uk-text-bold seller-reg">For Selling on Krishi-Mitra, You
                need to
                Register
                First
            </div>
            <div class="uk-padding-large uk-padding-remove-top">
                <div class="uk-margin-bottom">
                    <input class="uk-input uk-form-width-large" id="name" type="text" placeholder="Enter Name" name="name">
                </div>
                <div class="uk-margin-bottom">
                    <input class="uk-input uk-form-width-large" id="aadhaar_num" type="text"
                        placeholder="Enter Aadhaar Number" name="aadhaar_num">
                </div>
                <div class="uk-margin-bottom">
                    <input class="uk-input uk-form-width-large" id="gst_num" type="text" placeholder="Enter GST Number"
                        name="gst_num">
                </div>
                <div>
                    <input class="uk-input uk-form-width-large" id="trade_name" type="text" placeholder="Enter Trade Name"
                        name="trade_name">
                </div>
            </div>
            <div class="uk-padding-large uk-padding-remove-top">
                <button type="submit" class="uk-button uk-text-bold seller-btn">Submit</button>
            </div>
        </form>
    </div>
@endsection
