@extends('layouts.app')

@section('content')
    @if (count($cart_products) > 0)
        @php
            $x = 0;
            $y = 0;
            $z = 0;
        @endphp
        <div class="uk-width-1-1 uk-margin-remove uk-padding uk-flex uk-flex-row uk-flex-around cart_bag">
            <div class="uk-width-2-3 uk-margin-large-left uk-margin-right">
                <div class="uk-text-large uk-text-bold cart-color">MY CART</div>
                <hr>
                @foreach ($cart_products as $cart_product)
                    <div class="uk-card uk-card-default uk-padding uk-margin-bottom uk-flex uk-flex-row">

                        <div class="uk-width-1-3 uk-flex-middle uk-flex uk-flex-center uk-flex-column">
                            <img src="{{ isset($cart_product->product->coverPhotos) ? asset('uploads/products/' . $cart_product->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                width="200rem" uk-img />
                            <div class="uk-margin-top uk-flex uk-flex-row uk-flex-around">
                                <button class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                    onclick="addToCart('{{ $cart_product->id }}')">+</button>
                                <span class="card-quan-color">{{ $cart_product->qty }}</span>
                                <button class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                    value={{ $cart_product->qty }}
                                    onclick="subFromCart('{{ $cart_product->id }}')">-</button>
                            </div>
                        </div>
                        <div class="uk-width-2-3 uk-flex-start uk-margin-large-left uk-margin-right">
                            <div class="uk-text-bold uk-text-emphasis uk-margin-bottom">{{ $cart_product->product->name }}
                                ,
                                {{ $cart_product->product->type }} - 1 {{ $cart_product->product->unit }} </div>
                            <div>{!! $cart_product->product->desc !!}</div>
                            <div class="uk-margin-bottom">
                                <span class="uk-text-bold">Price :</span>
                                <span class="uk-text-bold uk-margin-small-right sdetail-price">
                                    ₹{{ sprintf('%.2f', $cart_product->product->price * $cart_product->qty) }}
                                </span>
                                <span class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                                    ₹{{ sprintf('%.2f', ($cart_product->product->price * $cart_product->qty) / (1 - $cart_product->product->discount)) }}</span>
                            </div>
                            <button class="uk-button uk-button-default card-remove" id={{ $cart_product->id }}
                                onclick="delFromCart('{{ $cart_product->id }}')">Remove</button>
                        </div>
                    </div>

                    @php
                        $x = sprintf('%.2f', $x + ($cart_product->product->price * $cart_product->qty) / (1 - $cart_product->product->discount));
                        
                        $y = sprintf('%.2f', $y + $cart_product->product->price * $cart_product->qty);
                        
                        $z = $x - $y;
                    @endphp
                @endforeach
                <a class="uk-button uk-button-default cart-checkout" href="{{ route('checkout') }}"
                    type="button">Checkout</a>
            </div>

            {{-- <div class="uk-width-1-3 uk-card uk-card-default uk-padding uk-margin-large-right">
                <li>Price:{{ $cart_product->price * $cart_product->qty }}</li>
                <li>Discount_rate:{{ $cart_product->discount }}</li>
                <li>Discounted_Price:{{ $cart_product->price * $cart_product->qty * (1 - $cart_product->discount) }}</li>
                <h2>The Total price is : {{ $x }}</h2>
            </div> --}}
            <div class="uk-width-1-3 uk-flex uk-flex-column   uk-margin-large-right">
                <div class="uk-margin">
                    <select class="uk-select uk-form-large">
                        <option>Select Address</option>
                        <option>Option 1</option>
                    </select>
                </div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header uk-padding  uk-text-bold">
                        PRICE DETAILS
                    </div>

                    <div class="uk-card-body">
                        <div class="uk-flex uk-flex-row uk-flex-between uk-margin-bottom">
                            <div>Price</div>
                            <div>{{ $x }}</div>
                        </div>
                        <div class="uk-flex uk-flex-row uk-flex-between uk-margin-bottom">
                            <div>Discount</div>
                            <div class="cart-dis"> - {{ $z }}</div>
                        </div>
                        <div class="uk-flex uk-flex-row uk-flex-between uk-margin-bottom">
                            <div>Delivery Charges</div>
                            <div>None</div>
                        </div>
                        <div class="uk-flex uk-flex-row uk-text-emphasis uk-text-bold uk-flex-between">
                            <div>Total Price</div>
                            <div>{{ $y }}</div>
                        </div>
                    </div>
                    <div class="uk-card-footer uk-padding uk-text-bold cart-dis">
                        You will save {{ $z }} in this order
                    </div>
                </div>
            </div>

        </div>


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
