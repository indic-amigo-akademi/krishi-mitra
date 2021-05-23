@extends('layouts.app')
@section('content')
    @if (count($data_arr[0]) > 0)
        {{-- <h1>{{ $data_arr[1] }}</h1> --}}
        <div
            class="uk-flex uk-flex-wrap uk-flex-around uk-padding-large uk-padding-remove-bottom uk-padding-remove-horizontal sprod">

            @foreach ($data_arr[0] as $prod)
                <div
                    class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-flex
                                                                                                                             uk-flex-column uk-flex-between uk-margin-large-bottom uk-margin-right uk-margin-left">
                    <a href="/sproducts_detail/{{ $prod->id }}" class="uk-flex uk-flex-center">
                        <img src={{ URL::to('/uploads/products/' . $prod->cover) }} uk-img />
                    </a>
                    <div class="uk-padding-small">
                        <div class="uk-margin-small-bottom">
                            <span class="uk-text-bold">{{ $prod->type }}</span> |
                            <span style="font-family: cursive">{{ $prod->name }}</span>
                        </div>
                        <div class="uk-margin-small-bottom uk-text-bold uk-text-small sprod-color">₹ {{ $prod->price }}
                        </div>
                        <div class="uk-text-small">Unit : {{ $prod->unit }}</div>
                        {{-- <div>{!! $prod->desc !!}</div> --}}
                    </div>
                    <div
                        class="uk-flex uk-flex-between uk-card-footer uk-padding-remove-bottom uk-padding-remove-horizontal">
                        @if ($data_arr[1] == 'customer')
                            <a href="/cart_add" type=" button" class="uk-text-primary">Add to Bag</a>
                        @endif
                        @if ($data_arr[1] == 'seller')
                            <a href="/cart_add" type=" button" class="uk-text-primary">Add</a>
                            <a href="/product_edit/{{ $prod->id }}" type=" button" class="uk-text-warning">Edit</a>
                            <a href="/product_destroy/{{ $prod->id }}" type=" button" class="uk-text-danger">Remove</a>
                        @endif
                        @if ($data_arr[1] == 'admin')
                            <a href="/product_edit/{{ $prod->id }}" type=" button" class="uk-text-warning">Edit</a>
                            <a href="/product_destroy/{{ $prod->id }}" type=" button" class="uk-text-danger">Remove</a>
                        @endif
                    </div>
                </div>
            @endforeach
            <div
                class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-margin-large-bottom uk-margin-right uk-margin-left">
                <div class="uk-text-large uk-text-center uk-text-bold">Add New Product
                </div>
                <div class="uk-margin uk-padding-small uk-flex uk-flex-center sprod-add-new">
                    <a href="/create_product" type=" button"
                        class="uk-heading-small uk-text-muted uk-margin-remove uk-link-heading ri-add-circle-fill"></a>
                </div>
            </div>
        </div>
    @else
        NO PRODUCTS FOUND
    @endif
@endsection
