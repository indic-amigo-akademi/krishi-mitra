@extends('layouts.app')

@section('content')
    <section class="uk-height-1-1 uk-padding-small sprod">
        <a class="uk-button uk-button-default" href="{{ route('seller.product.create') }}"> <i class="ri-add-fill"></i>
            Add New
            Product</a>
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
                            <div class="uk-margin-small-bottom">
                                <span class="uk-text-bold">{{ $product->category }}</span> |
                                <span style="font-family: cursive">{{ $product->name }}</span>
                            </div>
                            <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                <span class="sprod-color">
                                    ₹ {{ $product->price }}
                                </span>
                                per {{ $product->unit }}
                            </div>
                            {{-- <div>{!! $product->desc !!}</div> --}}
                        </div>
                        <div
                            class="uk-flex uk-flex-between uk-card-footer uk-padding-remove-bottom uk-padding-remove-horizontal">
                            <a href="{{ route('seller.product.edit', $product->id) }}" type=" button"
                                class="uk-text-warning">Edit</a>

                            <form action="{{ route('product.destroy', $product->id) }}"
                                id="{{ 'removeProduct' . $product->id }}" method="post">
                                @csrf
                                <a href="#"
                                    onclick="document.getElementById('{{ 'removeProduct' . $product->id }}').submit()"
                                    class="uk-margin-left uk-link-heading sdetail-remove uk-text-danger uk-text-bold">Remove</a>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="uk-text-center"> No Products Uploaded</h2>
            @endif
        </div>
    </section>
@endsection
