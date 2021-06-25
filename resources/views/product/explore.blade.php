@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="">
            <div class="uk-width-1-1 uk-width-1-4@l"></div>
            <div class="uk-padding-small uk-width-1-1 uk-width-3-4@l">
                <h2>{{ $page_title }}</h2>
                @if (count($products) > 0)
                    <div class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-left" style="max-width: 1200px;">
                        @foreach ($products as $prod)
                            @if ($prod->active == 1)
                                <div
                                    class="uk-card uk-card-default uk-width-1-2 uk-width-1-3@s uk-width-1-4@l uk-flex-left product-box">
                                    <div class="uk-card-media-top">
                                        <a href="{{ route('product.view', $prod->slug) }}" class="uk-flex uk-flex-center">
                                            <img src="{{ isset($prod->coverPhotos) ? asset('uploads/products/' . $prod->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                                uk-img />
                                        </a>
                                    </div>
                                    <div class="uk-padding-remove">
                                        <div class="uk-card-body uk-padding-small">
                                            <div class="uk-margin-small-bottom">
                                                <a href="{{ route('product.view', $prod->slug) }}">
                                                    <span style="font-family: cursive">{{ $prod->name }}</span>
                                                </a>
                                                |
                                                <a href="{{ route('explore') . '?c=' . $prod->type }}">
                                                    <span class="uk-text-bold">{{ $prod->type }}</span>
                                                </a>
                                            </div>
                                            <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                                <span class="sprod-color">
                                                    ₹ {{ $prod->price }}
                                                </span>
                                                per {{ $prod->unit }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-flex uk-flex-between uk-card-footer uk-padding-small">
                                        <a href="#" onclick="addToCart('{{ $prod->id }}')" class="uk-text-primary">
                                            <i class="ri-shopping-bag-line"></i>
                                            <span class="icon-text">Add to Cart</span>
                                        </a>
                                        <a href="#" onclick="buyNow('{{ $prod->id }}')" class="uk-text-primary">
                                            <i class="ri-shopping-cart-line"></i>
                                            <span class="icon-text">Buy Now</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    {{ $products->appends(request()->input())->links() }}
                @else
                    <p> Products will be updated soon</p>
                @endif

            </div>
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
