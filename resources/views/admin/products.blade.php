@extends('layouts.app')

@section('content')
    <section class="uk-height-1-1 uk-padding-small sprod">
        <div class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-around uk-padding-remove-bottom uk-padding-remove-horizontal">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div
                        class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-flex
                                                                                                                                                                                                                                                                             uk-flex-column uk-flex-between uk-margin-large-bottom uk-margin-right uk-margin-left">
                        <a href="{{ route('seller.product.view', $product->slug) }}" class="uk-flex uk-flex-center">
                            <img src="{{ isset($product->coverPhotos) && count($product->coverPhotos) > 0 ? asset('uploads/products/' . $product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                uk-img />
                        </a>

                        <div class="uk-padding-small">
                            <span style="font-family: cursive">Seller:
                                {{ $product->seller->trade_name }}({{ $product->seller->name }})</span>

                            <div class="uk-margin-small-bottom">
                                <span class="uk-text-bold">{{ $product->category }}</span> |
                                <span style="font-family: cursive">{{ $product->name }}</span> <br>
                                <span style="font-family: cursive">Activation Status:{{ $product->active }}</span>
                            </div>
                            <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                <span class="sprod-color">
                                    ₹ {{ $product->price }}
                                </span>
                                per {{ $product->unit }}
                            </div>
                        </div>
                        <div>
                            @if ($product->active == 1)
                                <a href="{{ route('product.deactivate', $product->id) }}" type=" button"
                                    class="uk-text-warning">Inactivate</a>
                            @else
                                <a href="{{ route('product.activate', $product->id) }}" type=" button"
                                    class="uk-text-warning">Activate</a>
                            @endif
                        </div>


                    </div>
                @endforeach
            @else
                <p> No Products Uploaded</p>
            @endif
        </div>
    </section>
@endsection
