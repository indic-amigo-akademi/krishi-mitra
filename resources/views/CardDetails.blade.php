@extends('layouts.app')

@section('content')
    <form action="{{ route('OrderProcessed.card') }}">
        <div class="form-group">
            <label for="card">Select Card Type:</label>
            <input type="text" class="form-control" id="card" name="card">
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
