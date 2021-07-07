@extends('layouts.app')

@section('content')
    <form action="{{ route('OrderProcessed') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="card">Select Card Type:</label>
            <input type="text" class="form-control" id="card" name="card">
        </div>
        <div class="form-group">
            <input type="hidden" class="form-control" id="card" name="address_radio" value={{ $addr }}>
            <input type="hidden" class="form-control" id="card" name="buy_type" value={{ $buy_type }}>
            <input type="hidden" class="form-control" id="card" name="prod_id" value={{ $buy_now_id }}>
        </div>
        <div class="form-group">
            <label for="card">Enter Card Number:</label>
            <input type="number" class="form-control" id="card_num" name="card_num">
        </div>
        <div class="form-group">
            <label for="card">Enter Card Holder Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="card">Enter Expiry date:</label>
            <input type="text" class="form-control" id="card_date" name="card_date">
        </div>
        <div class="form-group">
            <label for="card">Enter CVV:</label>
            <input type="number" class="form-control" id="cvv" name="cvv">
        </div>

        <button type="submit" class="btn btn-default">Proceed</button>
    </form>
@endsection
