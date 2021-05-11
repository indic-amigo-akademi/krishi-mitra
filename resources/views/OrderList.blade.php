@extends('layouts.app')

@section('content')
    <h1>List of all orders</h1>
    @if (count($ord) > 0)
        @foreach ($ord as $o)
            <a href="/orders/{{ $o->order_id }}">{{ $o->order_id }}</a>
            <p>Total Price:{{ $o->tot }}</p><br>
        @endforeach
    @else
        NO ORDER HISTORY
    @endif
@endsection
