@extends('layouts.app')

@section('content')
    <h1>List of all products in cart</h1>
    @if (count($products) > 0)
        @php
            $x = 0;
        @endphp
        @foreach ($products as $prod)
            <ul id="menu" style="display:inline;">
                <li>Type:{{ $prod->type }}</li>
                <li>Description:{{ $prod->desc }}</li>
                <li>Quantity:{{ $prod->qty }}</li>
                <button id={{ $prod->id }} onclick="add()">+</button>
                <button id={{ $prod->id }} onclick="sub()">-</button>
                <li>Price:{{ $prod->price * $prod->qty }}</li>
                <li>Discount_rate:{{ $prod->discount }}</li>
                <li>Discounted_Price:{{ $prod->price * $prod->qty * (1 - $prod->discount) }}</li>
                <img src={{ URL::to('/uploads/products/' . $prod->cover) }} width="100" height="100">
                <button id={{ $prod->id }} onclick="del()">Remove From Cart</button><br><br>
            </ul>
            @php
                $x = $x + $prod->price * $prod->qty * (1 - $prod->discount);
            @endphp
        @endforeach
        <h2>The Total price is : {{ $x }}</h2>
    @else
        Cart is Empty
    @endif
@endsection
@push('JsScript')
    <script>
        function del() {
            var x = {
                id: event.target.id
            }
            console.log('ID IS');
            console.log(x)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/cart/delete',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(x),
                success: function(data) {
                    console.log('Posted');
                }

            });
            location.reload();
        }

        function add() {
            var x = {
                id: event.target.id
            }
            console.log('ID IS');
            console.log(x)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/cart/incr',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(x),
                success: function(data) {
                    console.log('Posted');
                }

            });
            location.reload();
        }

        function sub() {
            var x = {
                id: event.target.id
            }
            console.log('ID IS');
            console.log(x)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/cart/decr',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(x),
                success: function(data) {
                    console.log('Posted');
                }

            });
            location.reload();
        }

    </script>
@endpush
