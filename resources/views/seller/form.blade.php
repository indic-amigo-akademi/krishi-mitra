@extends('layouts.app')

@section('content')
    <div class="uk-width-1-1 uk-height-1-1 uk-background-cover uk-background-norepeat"
        style="background-image:url({{ asset('images/background/img3.jpg') }})">
        <form action="{{ route('seller.register') }}" method="POST">
            @csrf
            <div class="uk-padding-large uk-text-large uk-text-bold seller-reg">For Selling on Krishi-Mitra, You
                need to
                Register
                First
            </div>
            <div class="uk-padding-large uk-padding-remove-top">
                <div class="uk-margin-bottom">
                    <input class="uk-input uk-form-width-large @error('name') uk-form-danger @enderror" id="name"
                        type="text" value="{{ old('name') }}" placeholder="Enter Name" name="name">
                    @error('name')
                        <div class="uk-alert-danger" uk-alert>
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="uk-margin-bottom">
                    <input class="uk-input uk-form-width-large @error('aadhaar') uk-form-danger @enderror" id="aadhaar"
                        type="text" value="{{ old('aadhaar') }}" placeholder="Enter Aadhaar Number" name="aadhaar">
                    @error('aadhaar')
                        <div class="uk-alert-danger" uk-alert>
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="uk-margin-bottom">
                    <input class="uk-input uk-form-width-large @error('gstin') uk-form-danger @enderror" id="gstin"
                        type="text" value="{{ old('gstin') }}" placeholder="Enter GST Number" name="gstin">
                    @error('gstin')
                        <div class="uk-alert-danger" uk-alert>
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div>
                    <input class="uk-input uk-form-width-large @error('trade_name') uk-form-danger @enderror"
                        id="trade_name" type="text" value="{{ old('trade_name') }}" placeholder="Enter Trade Name"
                        name="trade_name">
                    @error('trade_name')
                        <div class="uk-alert-danger" uk-alert>
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="uk-padding-large uk-padding-remove-top">
                <button type="submit" class="uk-button uk-text-bold seller-btn">Register</button>
            </div>
        </form>
    </div>
@endsection
