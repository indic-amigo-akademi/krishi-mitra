@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-around">

            @if (count($products) > 0)
                <div class="product-slider uk-position-relative uk-visible-toggle uk-light uk-padding-small uk-margin-horizontal"
                    tabindex="-1" uk-slider="sets: true">
                    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-5@l uk-grid">
                        @foreach ($products as $prod)
                            @if ($prod->active == 1)
                                <li>
                                    <div class="uk-card uk-card-default product-box">
                                        <div class="uk-card-media-top">
                                            <a href="{{ route('product.view', $prod->slug) }}"
                                                class="uk-flex uk-flex-center">
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
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <a class="uk-position-center-left uk-position-small slidenav" href="#" uk-slidenav-previous
                        uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small slidenav" href="#" uk-slidenav-next
                        uk-slider-item="next"></a>

                </div>
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
