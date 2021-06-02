@extends('layouts.app')

@section('content')
    <form action="{{ route('CheckoutForm') }}">
        <div class="form-group">
            <label for="delivery">Delivery Address type:</label>
            <input type="text" class="form-control" id="type" name="type">
        </div>
        <div class="form-group">
            <label for="delivery">Street:</label>
            <input type="text" class="form-control" id="street" name="street">
        </div>
        <div class="form-group">
            <label for="delivery">House Number:</label>
            <input type="number" class="form-control" id="house_no" name="house_no">
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
