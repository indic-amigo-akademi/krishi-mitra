@extends('layouts.app')
<?php $i = 1; ?>
@section('content')
    <h1>List of all orders</h1>

    @if (count($ord) > 0)
        @foreach ($ord as $o)
            {{ $i++ }}) Order_ID:<a href="/orders/{{ $o->order_id }}">{{ $o->order_id }}</a>
            <p>Total Price:{{ $o->tot }} Date is: {{ $o->created_at }}</p><br>

        @endforeach
    @else
        NO ORDER HISTORY
    @endif
@endsection
