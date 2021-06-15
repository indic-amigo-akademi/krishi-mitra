@extends('layouts.app')
@section('styles')
    <style>
        .search-container {
            float: right;

        }

        .search-container button {
            float: right;
            padding: 6px;
            margin-top: 8px;
            margin-right: 16px;
            background: #ddd;
            font-size: 17px;
            border: none;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: blue;
        }

    </style>
@endsection
@section('content')
    <section class="uk-height-1-1 uk-padding-small sprod">
        <div
            class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-around uk-padding-remove-bottom uk-padding-remove-horizontal">

            @if (count($products) > 0)
                @foreach ($products as $prod)
                    @if ($prod->active == 1)
                        <div
                            class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-flex uk-flex-column uk-flex-between uk-margin-large-bottom uk-margin-right uk-margin-left">
                            <a href="{{ route('seller.product.view', $prod->slug) }}" class="uk-flex uk-flex-center">
                                <img src="{{ isset($prod->coverPhotos) ? asset('uploads/products/' . $prod->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                    uk-img />
                            </a>
                            <div class="uk-padding-small">
                                <div class="uk-margin-small-bottom">
                                    <span class="uk-text-bold">{{ $prod->type }}</span> |
                                    <span style="font-family: cursive">{{ $prod->name }}</span>
                                </div>
                                <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                    <span class="sprod-color">
                                        ₹ {{ $prod->price }}
                                    </span>
                                    per {{ $prod->unit }}
                                </div>
                            </div>
                            <div
                                class="uk-flex uk-flex-between uk-card-footer uk-padding-remove-bottom uk-padding-remove-horizontal">
                                <a href="#" onclick="addToCart('{{ $prod->id }}')" class="uk-text-primary">
                                    Add to Cart
                                </a>
                                <a href="#" onclick="buyNow('{{ $prod->id }}')" class="uk-text-primary">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p> Products will be updated soon</p>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function addToCart(id) {
            event.preventDefault();
            @if (Auth::check())
                let x = {
                id: id
                }
                /*$.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
            
                $.ajax({
                url: '/cart/store',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(x),
                success: function(data) {
                console.log('Posted');
                }
                });*/
                fetch('/cart/store', {
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
            @else
                UIkit.modal($("#signin-form").get(0)).show();
            @endif
        }

        function buyNow(id) {
            @if (Auth::check())
                location.href = "{{ route('checkout_buynow', '') }}/"+id;
            @else
                UIkit.modal($("#signin-form").get(0)).show();
            @endif
        }

    </script>
@endsection
