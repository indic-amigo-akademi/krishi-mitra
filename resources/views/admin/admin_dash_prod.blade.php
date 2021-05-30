@extends('layouts.app')

@section('content')
    <section class="uk-height-1-1 uk-padding-small sprod">
        {{-- <a class="uk-button uk-button-default" href="{{ route('product.create') }}"> <i class="ri-add-fill"></i> Add New
            Product</a> --}}
        <div
            class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-around uk-padding-remove-bottom uk-padding-remove-horizontal">
            @if (count($products) > 0)
                @foreach ($products as $prod)
                    <div
                        class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-flex
                                                                                                                                                                                                                                                 uk-flex-column uk-flex-between uk-margin-large-bottom uk-margin-right uk-margin-left">
                        <a href="{{ route('seller.product.view', $prod->slug) }}" class="uk-flex uk-flex-center">
                            <img src="{{ isset($prod->coverPhotos) ? asset('uploads/products/' . $prod->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                uk-img />
                        </a>

                        <div class="uk-padding-small">
                            Seller_ID
                            <span style="font-family: cursive">Seller_ID:{{ $prod->seller_id }}</span>

                            <div class="uk-margin-small-bottom">
                                <span class="uk-text-bold">{{ $prod->type }}</span> |
                                <span style="font-family: cursive">{{ $prod->name }}</span>
                                <span style="font-family: cursive">Activation Status:{{ $prod->active }}</span>

                            </div>
                            <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                <span class="sprod-color">
                                    ₹ {{ $prod->price }}
                                </span>
                                per {{ $prod->unit }}
                                <div>{{ $prod->coverPhotos }}</div>
                            </div>
                            {{-- <div>{!! $prod->desc !!}</div> --}}
                        </div>
                        @if ($prod->active == 1)
                            <div> <a href="/product/inactivate/{{ $prod->id }}" type=" button"
                                    class="uk-text-warning">Inactivate</a>
                            @else
                                <a href="/product/activate/{{ $prod->id }}" type=" button"
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
