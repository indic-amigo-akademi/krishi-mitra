@extends('layouts.app')

@section('content')
    <section class="container cart-container">
        <div class="uk-flex uk-flex-row uk-flex-around uk-padding uk-flex-wrap">
            <div class="uk-width-1-1 uk-width-2-3@m">
                <div class="uk-text-large uk-text-bold cart-color">MY CART</div>
                <hr>
                @if (count($cart_products) > 0)
                    @foreach ($cart_products as $cart_product)
                        <div
                            class="uk-card uk-card-default uk-padding-small uk-margin-bottom uk-margin-right uk-flex uk-flex-row uk-flex-wrap">
                            <div class="uk-width-1-1 uk-width-1-3@m uk-flex uk-flex-column">
                                <img src="{{ isset($cart_product->product->coverPhotos) ? asset('uploads/products/' . $cart_product->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                    width="200rem" uk-img class="uk-margin-auto" />
                                <div class="uk-margin-top uk-flex uk-flex-row uk-flex-center">
                                    <button class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                        onclick="addToCart('{{ $cart_product->id }}')">+</button>
                                    <span class="card-quan-color">{{ $cart_product->qty }}</span>
                                    <button class="uk-button-default uk-margin-left uk-margin-right cart-quan"
                                        value={{ $cart_product->qty }}
                                        onclick="subFromCart('{{ $cart_product->id }}')">-</button>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-2-3@m">
                                <div class="uk-text-bold uk-text-emphasis uk-margin-small-bottom">
                                    {{ $cart_product->product->name }}
                                    ,
                                    {{ $cart_product->product->type }} - 1 {{ $cart_product->product->unit }}
                                </div>
                                <div class="uk-text-emphasis uk-margin-bottom">
                                    {{ $cart_product->product->seller->trade_name }}
                                </div>
                                <div class="uk-margin-small-bottom">
                                    <span class="uk-text-bold">Total Price: </span>
                                    <span class="uk-text-bold uk-margin-small-right sdetail-price">
                                        ₹{{ sprintf('%.2f', $cart_product->total_discounted_price) }}
                                    </span>
                                    <span
                                        class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                                        ₹{{ sprintf('%.2f', $cart_product->total_price) }}
                                    </span>
                                </div>
                                <button class="uk-button uk-button-default card-remove" id={{ $cart_product->id }}
                                    onclick="Notiflix.confirmdb('Are u sure!', 'Do you want to delete this product from cart?', war, 'Yes', 'No', 'delFromCart
                                                                                        ', '');">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                        <p class="uk-text-bold uk-text-center">Cart is Empty</p>
                    </div>
                @endif
            </div>
            <div
                class="uk-width-1-1 uk-width-1-3@m uk-flex uk-flex-column{{ count($cart_products) > 0 ? '' : ' d-none' }}">
                <div class="uk-margin">
                    <select class="uk-select uk-form-large">
                        <option disabled>Select Address</option>
                        @foreach ($addresses as $address)
                            <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header uk-text-bold">
                        PRICE DETAILS
                    </div>

                    <div class="uk-card-body">
                        <div class="uk-flex uk-flex-row uk-flex-between uk-margin-bottom">
                            <div>Price</div>
                            <div>₹{{ sprintf('%.2f', $cart_products->sum('total_price')) }}</div>
                        </div>
                        <div class="uk-flex uk-flex-row uk-flex-between uk-margin-bottom">
                            <div>Discount</div>
                            <div class="text-theme-color1"> -
                                ₹{{ sprintf('%.2f', $cart_products->sum('total_price') - $cart_products->sum('total_discounted_price')) }}
                            </div>
                        </div>
                        <div class="uk-flex uk-flex-row uk-flex-between uk-margin-bottom">
                            <div>Delivery Charges</div>
                            <div class="uk-text-primary uk-text-uppercase">None</div>
                        </div>
                        <hr>
                        <div class="uk-flex uk-flex-row uk-text-emphasis uk-text-bold uk-flex-between">
                            <div>Total Price</div>
                            <div>₹{{ sprintf('%.2f', $cart_products->sum('total_discounted_price')) }}</div>
                        </div>
                    </div>
                    <div class="uk-card-footer uk-text-bold text-theme-color1">
                        You will save
                        ₹{{ sprintf('%.2f', $cart_products->sum('total_price') - $cart_products->sum('total_discounted_price')) }}
                        in
                        this order
                    </div>
                </div>
                <a class="uk-button uk-button-default uk-margin-top cart-checkout" href="{{ route('checkout') }}"
                    type="button">Checkout</a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function delFromCart(id) {
            var x = {
                id: id
            }
            fetch('/cart/delete', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
            }).then(function(response) {
                Notiflix.Notify.success('Yippee!', 'Product deleted from the cart!');
                location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
                Notiflix.Notify.error('Oops!', 'Product couldn\'t be deleted from the cart!');
            });
        }

        function addToCart(id) {
            var x = {
                id: id
            }
            console.log('ID IS');
            fetch('/cart/incr', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
            }).then(function(response) {
                Notiflix.Notify.success('Yippee!', 'Product added to the cart!');
                location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
                Notiflix.Notify.error('Oops!', 'Product couldn\'t be added to the cart!');
            });

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
            fetch('/cart/decr', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
            }).then(function(response) {
                Notiflix.Notify.success('Yippee!', 'Product subtracted from the cart!');
                location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
                Notiflix.Notify.error('Oops!', 'Product couldn\'t be subtracted from the cart!');
            });
        }
    </script>
@endsection
