@extends('layouts.app')
@section('content')
    <h1>Seller Registration</h1>
    <form action="/seller_create" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
            <label for="gst_num">GST_NUMBER</label>
            <input type="text" class="form-control" id="gst_num" placeholder="enter gst_num" name="gst_num">
        </div>
        <div class="form-group">
            <label for="trade_name">Trade Name</label>
            <input type="text" class="form-control" id="trade_name" placeholder="enter trade_name" name="trade_name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
