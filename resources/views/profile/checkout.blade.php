@extends('layouts.app')

@section('content')
    <form action="{{ route('CheckoutForm') }}" method='post'>
        @csrf
        <div class="uk-padding uk-flex uk-flex-center uk-flex-wrap container checkout-container">
            <div class="uk-margin-top uk-width-2-3@m checkout-block address_block" style="display:block;">
                <div class="uk-card uk-card-default uk-margin-large ">
                    <div class="uk-card-header uk-padding-small checkout_no">
                        <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no1"> 1</span>
                        <span class="uk-text-bold">DELIVERY ADDRESS</span>
                    </div>
                    @if (count(Auth::user()->addresses) > 0)
                        @foreach (Auth::user()->addresses as $addr)
                            <div class="uk-padding-small uk-margin-small-top">
                                <input class="uk-radio uk-margin-small-left" type="radio" name="address_radio"
                                    data-address="{{ $addr->full_address }}" value={{ $addr->id }} checked>
                                <span class="uk-text-bold uk-margin-left">{{ $addr->name }}</span>
                                <span class="uk-margin-left uk-text-small checkout_add_type">{{ $addr->type }}</span>
                                <span class="uk-text-bold uk-margin-left">{{ $addr->mobile }}</span>
                            </div>
                            <div class="uk-padding-small uk-padding-remove-top uk-padding-remove-left uk-margin-large-left">
                                <span>{{ $addr->full_address }}</span><br>
                            </div>
                        @endforeach
                    @else
                        <p class="uk-padding-small"> No Address Available</p>
                    @endif
                    <div class="uk-card-footer uk-padding-small uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                        <a class="uk-link-heading uk-margin-left uk-text-bold text-theme-color1"
                            href="{{ route('address.add.view') }}">
                            <i class="ri-add-circle-line"></i> ADD NEW ADDRESS
                        </a>
                        <a class="uk-button uk-button-default uk-text-bold checkout_next" @if (count(Auth::user()->addresses) > 0) data-type="order" @else data-type="add_address" @endif>Next</a>

                    </div>
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 2</span>
                    <span class="uk-text-bold">ORDER SUMMARY</span>
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 3</span>
                    <span class="uk-text-bold">PAYMENT DETAILS</span>
                </div>
            </div>


            <div class="uk-margin-top uk-width-2-3@m checkout-block order_block" style="display:none;">
                <div class="uk-card uk-card-default uk-margin-large complete-checkout" data-type="address">
                    <div class="header uk-padding-small checkout_next" data-type="address">
                        <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 1</span>
                        <span class="uk-text-bold">DELIVERY ADDRESS</span>
                        <span class="uk-align-right uk-margin-right uk-text-center checkout_check"> <i
                                class=" ri-check-fill"></i></span>
                    </div>
                    <div class="body uk-padding-small"></div>
                </div>
                <div class="uk-card uk-card-default uk-margin-large ">
                    <div class="uk-card-header uk-padding-small checkout_no">
                        <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no1"> 2</span>
                        <span class="uk-text-bold">ORDER SUMMARY</span>
                    </div>
                    @isset($cart_products)
                        @foreach ($cart_products as $cart_product)
                            <div class="uk-card-header uk-padding uk-flex uk-flex-row">
                                <div class="uk-width-1-3 uk-flex-middle uk-flex uk-flex-column">
                                    <img src="{{ isset($cart_product->product->coverPhotos) ? asset('uploads/products/' . $cart_product->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                        width="200rem" uk-img class="uk-margin-auto" />
                                    <div class="uk-margin-top uk-flex uk-flex-row uk-flex-center">
                                        <button type="button" class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                            onclick="addToCart('{{ $cart_product->id }}')">+</button>
                                        <span class="card-quan-color">{{ $cart_product->qty }}</span>
                                        <button type="button" class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                            value={{ $cart_product->qty }}
                                            onclick="subFromCart('{{ $cart_product->id }}')">-</button>
                                    </div>
                                </div>
                                <div class="uk-width-2-3 uk-flex-start uk-margin-large-left uk-margin-right">
                                    <div class="uk-text-bold uk-text-emphasis uk-margin-small-bottom">
                                        {{ $cart_product->product->name }}
                                        ,
                                        {{ $cart_product->product->category }} - 1 {{ $cart_product->product->unit }}
                                    </div>
                                    <div class="uk-text-emphasis uk-margin-bottom">
                                        {{ $cart_product->product->seller->trade_name }}
                                    </div>
                                    <div class="uk-margin-small-bottom">
                                        <span class="uk-text-bold">Quantity :</span>
                                        <span class="uk-text-bold">{{ $cart_product->qty }}</span>
                                    </div>
                                    <div class="uk-margin-small-bottom">
                                        <span class="uk-text-bold">Total Price :</span>
                                        <span class="uk-text-bold uk-margin-small-right sdetail-price">
                                            ₹{{ sprintf('%.2f', $cart_products->sum('total_discounted_price')) }}
                                        </span>
                                        <span
                                            class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                                            ₹{{ sprintf('%.2f', $cart_products->sum('total_price')) }}</span>
                                    </div>

                                    <button type="button" class="uk-button uk-button-default card-remove"
                                        id={{ $cart_product->id }}
                                        onclick="delFromCart('{{ $cart_product->id }}')">Remove</button>
                                </div>
                            </div>
                        @endforeach
                        <div class="uk-padding-small uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                            <span class="uk-margin-left uk-text-bold">Total:
                                ₹{{ sprintf('%.2f', $cart_products->sum('total_discounted_price')) }}</span>
                            <a class="uk-button uk-button-default uk-text-bold checkout_next" data-type="payment">Next</a>
                        </div>
                    @endisset

                    @isset($buy_product)
                        <div class="uk-card-header uk-padding uk-flex uk-flex-row">
                            <div class="uk-width-1-3 uk-flex-middle uk-flex uk-flex-column">
                                <img src="{{ isset($buy_product->coverPhotos) ? asset('uploads/products/' . $buy_product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                    width="200rem" uk-img class="uk-margin-auto" />
                                <div class="uk-margin-top uk-flex uk-flex-row uk-flex-center">
                                    {{-- <button type="button" class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                        onclick="addToCart('{{ $buy_product->id }}')">+</button> --}}
                                    <span class="card-quan-color">1</span>
                                    {{-- <button type="button" class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                        value="1" onclick="subFromCart('{{ $buy_product->id }}')">-</button> --}}
                                </div>
                            </div>
                            <div class="uk-width-2-3 uk-flex-start uk-margin-large-left uk-margin-right">
                                <div class="uk-text-bold uk-text-emphasis uk-margin-small-bottom">
                                    {{ $buy_product->name }}
                                    ,
                                    {{ $buy_product->category }} - 1 {{ $buy_product->unit }}
                                </div>
                                <div class="uk-text-emphasis uk-margin-bottom">
                                    {{ $buy_product->seller->trade_name }}
                                </div>
                                <div class="uk-margin-small-bottom">
                                    <span class="uk-text-bold">Quantity :</span>
                                    <span class="uk-text-bold">1</span>
                                </div>
                                <div class="uk-margin-small-bottom">
                                    <span class="uk-text-bold">Total Price :</span>
                                    <span class="uk-text-bold uk-margin-small-right sdetail-price">
                                        ₹{{ sprintf('%.2f', $buy_product->discounted_price) }}
                                    </span>
                                    <span class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                                        ₹{{ sprintf('%.2f', $buy_product->price) }}</span>
                                </div>

                                {{-- <button type="button" class="uk-button uk-button-default card-remove"
                                    id={{ $buy_product->id }}
                                    onclick="delFromCart('{{ $buy_product->id }}')">Remove</button> --}}
                            </div>
                        </div>
                        <div class="uk-padding-small  uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                            <span class="uk-margin-left uk-text-bold">Total:
                                ₹{{ sprintf('%.2f', $buy_product->discounted_price) }}</span>
                            <a class="uk-button uk-button-default uk-text-bold checkout_next" data-type="payment">Next</a>
                        </div>
                    @endisset
                </div>
                <div class="uk-card uk-card-default uk-margin-large uk-padding-small">
                    <span class="uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 3</span>
                    <span class="uk-text-bold">PAYMENT DETAILS</span>
                </div>
            </div>


            <div class="uk-margin-top uk-width-2-3@m checkout-block payment_block" style="display:none;">
                <div class="uk-card uk-card-default uk-margin-large complete-checkout" data-type="address">
                    <div class="header uk-padding-small checkout_next" data-type="address">
                        <span class=" uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 1</span>
                        <span class="uk-text-bold">DELIVERY ADDRESS</span>
                        <span class="uk-align-right uk-margin-right uk-text-center checkout_check">
                            <i class=" ri-check-fill"></i>
                        </span>
                    </div>
                    <div class="body uk-padding-small">
                    </div>
                </div>
                <div class="uk-card uk-card-default uk-margin-large complete-checkout" data-type="order">
                    <div class="header uk-padding-small checkout_next" data-type="order">
                        <span class=" uk-margin-small-left uk-margin-right uk-text-bold checkout_no2"> 2</span>
                        <span class="uk-text-bold">ORDER SUMMARY</span>
                        <span class="uk-align-right uk-margin-right uk-text-center checkout_check">
                            <i class=" ri-check-fill"></i>
                        </span>
                    </div>
                    <div class="body uk-padding-small">
                        <span>
                            Order total:
                            @isset($cart_products)
                                ₹{{ sprintf('%.2f', $cart_products->sum('total_discounted_price')) }}
                                ({{ $cart_products->sum('qty') }} items)
                            @endisset
                            @isset($buy_product)
                                ₹{{ sprintf('%.2f', $buy_product->discounted_price) }}
                                (1 {{ $buy_product->unit }})
                            @endisset
                        </span>
                    </div>
                </div>
                <input type="hidden" name="buy_type" value={{ $buy }}>
                <input type="hidden" name="prod_id" value={{ $prod_id }}>
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
                        <input class="uk-radio uk-margin-small-left" type="radio" name="payment" value="cash" checked>
                        <span class="uk-text-bold uk-margin-left">Cash on Delivery</span>
                    </div>
                    <div class="uk-padding-small uk-flex uk-flex-row uk-flex-middle uk-flex-between">
                        <a class="uk-link-heading uk-margin-left uk-text-bold add_color">Order</a>
                        <button class="uk-button uk-button-default uk-text-bold checkout_next" data-type="proceed"
                            type="submit">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@section('scripts')
    <script>
        function delFromCart(id) {
            let x = {
                id: id
            }
            // console.log('ID IS');
            // console.log(x);

            fetch(route('cart.delete'), {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
            }).then(function(response) {
                console.log('Posted');
                location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
            });
        }

        function addToCart(id) {
            let x = {
                id: id
            }
            // console.log('ID IS');
            // console.log(x);


            fetch('/cart/incr', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
            }).then(function(response) {
                console.log('Posted');
                location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
            });
        }

        function subFromCart(id) {
            let x = {
                id: id
            }
            if (event.target.value == 1) {
                alert('Do you want to remove this item from the cart?')
            }
            // console.log('ID IS');
            // console.log(x);

            fetch('/cart/decr', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
            }).then(function(response) {
                console.log('Posted');
                location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
            });
        }

        $('.checkout_next').click(function(event) {
            let checkoutType;
            if ($(event.target).hasClass('checkout_next'))
                checkoutType = $(event.target).data("type");
            else
                checkoutType = $(event.target).parent().data("type");

            $(".checkout-block").each(function(i, e) {
                $(e).hide();
            });
            switch (checkoutType) {
                case "add_address":
                    location.href = "{{ route('address.add.view') }}";
                    break;
                case "address":
                case "order":
                case "payment":
                    let address = $("input[name='address_radio']:checked").data("address");
                    $(".complete-checkout[data-type='address'] .body").html(`<span>${address}</span>`);

                    $(`.checkout-block.${checkoutType}_block`).show();
                    break;
            }
        });
    </script>
@endsection
@endsection
