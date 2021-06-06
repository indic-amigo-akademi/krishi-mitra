@extends('layouts.app')

@section('content')
    <form action="{{ route('CheckoutForm') }}">
        <div class="uk-width-1-1@m uk-padding uk-flex uk-flex-center uk-flex-wrap cart_bag">


            <div id="address_block" class="uk-margin-top uk-width-2-3@m" style="display:block;">
                <div class="uk-card uk-card-default uk-margin-large ">
                    <div class="uk-card-header uk-padding-small checkout_no">
                        <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no1"> 1</span>
                        <span class="uk-text-bold">DELIVERY ADDRESS</span>
                    </div>
                    @if (count($addresses) > 0)
                        @foreach ($addresses as $addr)
                            <div class="uk-padding-small uk-margin-small-top">
                                <input class="uk-radio uk-margin-small-left" type="radio" name="address_radio"
                                    value={{ $addr->id }}>
                                <span class="uk-text-bold uk-margin-left">{{ $addr->name }}</span>
                                <span class="uk-margin-left uk-text-small checkout_add_type">{{ $addr->type }}</span>
                                <span class="uk-text-bold uk-margin-left">{{ $addr->mobile }}</span>
                            </div>
                            <div class="uk-padding-small uk-padding-remove-top uk-padding-remove-left uk-margin-large-left">
                                <span>{{ $addr->address1 }}, </span>
                                <span>{{ $addr->address2 }}, </span>
                                <span>{{ $addr->landmark }}, {{ $addr->city }}, </span>
                                <br>
                                <span>{{ $addr->state }}, PIN: {{ $addr->pincode }}</span><br>
                            </div>
                        @endforeach
                    @else
                        <p> No Address Available</p>
                    @endif
                    <div class="uk-card-footer uk-padding-small uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                        <a class="uk-link-heading uk-margin-left uk-text-bold add_color"
                            href="{{ route('address.add.view') }}" style="color: #3b7402">ADD NEW ADDRESS</a>
                        <a class="uk-button uk-button-default uk-text-bold checkout_next next-checkout-btn"
                            data-type="order" onclick="orderSummary();">Next</a>

                    </div>
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 2</span>
                    <span class="uk-text-bold">ORDER SUMMERY</span>
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 3</span>
                    <span class="uk-text-bold">PAYMENT DETAILS</span>
                </div>
            </div>


            <div id="order_block" class="uk-margin-top uk-width-2-3@m" style="display:none;">
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small" onclick="addressDetails();">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 1</span>
                    <span class="uk-text-bold">DELIVERY ADDRESS</span>
                    <span class="uk-align-right uk-margin-right uk-text-center checkout_check"> <i
                            class=" ri-check-fill"></i></span>
                </div>
                <div class="uk-card uk-card-default uk-margin-large ">
                    <div class="uk-card-header uk-padding-small checkout_no">
                        <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no1"> 2</span>
                        <span class="uk-text-bold">ORDER SUMMERY</span>
                    </div>
                    @foreach ($cart_products as $cart_product)
                        <div class="uk-card-header uk-padding uk-flex uk-flex-row">

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
                                <div class="uk-text-bold uk-text-emphasis uk-margin-bottom">
                                    {{ $cart_product->product->name }}
                                    ,
                                    {{ $cart_product->product->type }} - 1 {{ $cart_product->product->unit }} </div>
                                <div>{!! $cart_product->product->desc !!}</div>
                                <div class="uk-margin-bottom">
                                    <span class="uk-text-bold">Price :</span>
                                    <span class="uk-text-bold uk-margin-small-right sdetail-price">
                                        ₹{{ sprintf('%.2f', $cart_product->product->price * $cart_product->qty) }}
                                    </span>
                                    <span
                                        class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                                        ₹{{ sprintf('%.2f', ($cart_product->product->price * $cart_product->qty) / (1 - $cart_product->product->discount)) }}</span>
                                </div>
                                <button class="uk-button uk-button-default card-remove" id={{ $cart_product->id }}
                                    onclick="delFromCart('{{ $cart_product->id }}')">Remove</button>
                            </div>
                        </div>
                    @endforeach
                    <div class="uk-padding-small  uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                        <span class="uk-margin-left uk-text-bold">Order Confirmation</span>
                        <a class="uk-button uk-button-default uk-text-bold checkout_next next-checkout-btn"
                            data-type="payment" onclick="paymentDetails();">Next</a>
                    </div>
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 3</span>
                    <span class="uk-text-bold">PAYMENT DETAILS</span>
                </div>
            </div>


            <div id="payment_block" class="uk-margin-top uk-width-2-3@m" style="display:none;">
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small" onclick="addressDetails();">
                    <span class=" uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 1</span>
                    <span class="uk-text-bold">DELIVERY ADDRESS</span>
                    <span class="uk-align-right uk-margin-right uk-text-center checkout_check">
                        <i class=" ri-check-fill"></i>
                    </span>
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small" onclick="orderSummary();">
                    <span class=" uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 2</span>
                    <span class="uk-text-bold">ORDER SUMMERY</span>
                    <span class="uk-align-right uk-margin-right uk-text-center checkout_check">
                        <i class=" ri-check-fill"></i>
                    </span>
                </div>
                <div class="uk-card uk-card-default uk-margin-large ">
                    <div class="uk-card-header uk-padding-small checkout_no">
                        <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no1"> 3</span>
                        <span class="uk-text-bold">PAYMENT DETAILS</span>
                    </div>
                    <div class="uk-padding-small">
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="debit">
                        <span class="uk-text-bold uk-margin-left">Debit Card</span>
                        <br>
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="credit">
                        <span class="uk-text-bold uk-margin-left">Credit Card</span>
                        <br>
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="paytm">
                        <span class="uk-text-bold uk-margin-left">Paytm</span>
                        <br>
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="upi">
                        <span class="uk-text-bold uk-margin-left">UPI</span>
                        <br>
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="net">
                        <span class="uk-text-bold uk-margin-left">Net Banking</span>
                        <br>
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="cash">
                        <span class="uk-text-bold uk-margin-left">Cash on Delivery</span>
                    </div>
                    <div class="uk-padding-small uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                        <a class="uk-link-heading uk-margin-left uk-text-bold add_color">Order</a>
                        <button class="uk-button uk-button-default uk-text-bold checkout_next next-checkout-btn"
                            data-type="payment" href="">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@section('scripts')
    <script>
        function addressDetails() {
            var address = document.getElementById("order_block");
            address.style.display = "none";
            address = document.getElementById("address_block");
            address.style.display = "block";
            address = document.getElementById("payment_block");
            v.style.display = "none";
        }

        function orderSummary() {
            var order = document.getElementById("order_block");
            order.style.display = "block";
            order = document.getElementById("address_block");
            order.style.display = "none";
            order = document.getElementById("payment_block");
            order.style.display = "none";
        }

        function paymentDetails() {
            var payment = document.getElementById("order_block");
            payment.style.display = "none";
            payment = document.getElementById("address_block");
            payment.style.display = "none";
            payment = document.getElementById("payment_block");
            payment.style.display = "block";
        }

        $('.next-checkout-btn').click(function(event) {
            console.log("Hello")
        });

    </script>
@endsection
@endsection
