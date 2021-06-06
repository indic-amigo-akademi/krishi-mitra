@extends('layouts.app')

@section('content')
    <form action="{{ route('CheckoutForm') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="delivery">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="delivery">Mobile:</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
        </div>
        <div class="form-group">
            <label for="delivery">Delivery Address type:</label>
            <input type="text" class="form-control" id="type" name="type">
        </div>
        <div class="form-group">
            {{ $buy }}{{ $prod_id }}
            <input type="hidden" class="form-control" id="buy_type" name="buy_type" value="{{ $buy }}">
            <input type="hidden" class="form-control" id="prod_id" name="prod_id" value="{{ $prod_id }}">
        </div>
        <div class="form-group">
            <label for="delivery">Address1:</label>
            <input type="text" class="form-control" id="address1" name="address1">
        </div>
        <div class="form-group">
            <label for="delivery">address2:</label>
            <input type="text" class="form-control" id="address2" name="address2">
        </div>
        <div class="form-group">
            <label for="delivery">City:</label>
            <input type="text" class="form-control" id="city" name="city">
        </div>
        <div class="form-group">
            <label for="delivery">State:</label>
            <input type="text" class="form-control" id="state" name="state">
        </div>
        <div class="form-group">
            <label for="delivery">Pincode:</label>
            <input type="number" class="form-control" id="pincode" name="pincode">
        </div>
        <div class="form-group">
            <label for="delivery">LandMark:</label>
            <input type="text" class="form-control" id="landmark" name="landmark">
        </div>
        <br><br>
        <label for="delivery">Select Payment Method:</label>
        <div class="radio">
            <label><input type="radio" name="optradio" value="D/C">Debit Cart</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="optradio" value="PTM">Paytm</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="optradio" value="COD">Cash on Delivery</label>
        </div>
        <button type="submit" class="btn btn-default">Proceed</button>
    </form>
@endsection
