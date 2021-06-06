@extends('layouts.app')

@section('content')
    <h1>List of all products in cart</h1>
    @if (count($products) > 0)
        @php
            $x = 0;
        @endphp
        @foreach ($products as $prod)
            <ul id="menu" style="display:inline;">
                <li>Name:{{ $prod->name }}</li>
                <li>Type:{{ $prod->type }}</li>
                <li>Description:{{ $prod->desc }}</li>
                <li>Quantity:{{ $prod->qty }}</li>
                <button onclick="addToCart('{{ $prod->id }}')">+</button>
                <button value={{ $prod->qty }} onclick="subFromCart('{{ $prod->id }}')">-</button>
                <li>Price:{{ $prod->price * $prod->qty }}</li>
                <li>Discount_rate:{{ $prod->discount }}</li>
                <li>Discounted_Price:{{ $prod->price * $prod->qty * (1 - $prod->discount) }}</li>
                <img src={{ URL::to('/uploads/products/' . $prod->cover) }} width="100" height="100">
                <button id={{ $prod->id }} onclick="delFromCart('{{ $prod->id }}')">Remove From
                    Cart</button><br><br>
            </ul>
            @php
                $x = $x + $prod->price * $prod->qty * (1 - $prod->discount);
            @endphp
        @endforeach
        <h2>The Total price is : {{ $x }}</h2>
        <a href="{{ route('checkout') }}" type="button">Checkout</a>
    @else
        Cart is Empty
    @endif
@endsection
@section('scripts')
    <script>
        function delFromCart(id) {
            var x = {
                id: id
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
            setTimeout(function() {
                location.reload();
            }, 1000);
        }

        function addToCart(id) {
            var x = {
                id: id
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
            setTimeout(function() {
                location.reload();
            }, 1000);

        }

        function subFromCart(id) {
            var x = {
                id: id
            }
            if (event.target.value == 1) {
                alert('Do you want to remove this item from the cart?')
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
            setTimeout(function() {
                location.reload();
            }, 1000);
        }

    </script>
@endsection
