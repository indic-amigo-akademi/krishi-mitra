@extends('layouts.app')

@section('content')
    <h1>List of all products within the order</h1>
    @if (count($orders) > 0)
        @foreach ($orders as $o)
            <p>Item ID: {{ $o->product_id }}</t> Quantity: {{ $o->qty }} Price:{{ $o->price }}
                Discount:{{ $o->discount }} Date and Time:{{ $o->created_at }}</p>
        @endforeach
    @else
        NO ORDER HISTORY
    @endif
@endsection
