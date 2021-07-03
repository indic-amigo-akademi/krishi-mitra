@extends('layouts.app')
@section('content')
    <div class="uk-height-1-1 uk-padding uk-flex uk-flex-around sdetail">
        <div class="uk-card uk-card-default">
            <div class="uk-card-body uk-flex uk-flex-row uk-flex-middle uk-flex-wrap">
                <div class="uk-padding-small uk-flex uk-flex-center">
                    <img src="{{ isset($product->coverPhotos) ? asset('uploads/products/' . $product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                        width="400px" height="400px" uk-img />
                </div>
                <div class="uk-padding-small">
                    <div>
                        <span class="uk-text-large uk-text-emphasis uk-text-bold">{{ $product->name }}</span>
                    </div>
                    <hr>
                    <div class="uk-width-1-1@m uk-inline">
                        <div>
                            <span class="uk-text-bold">Available Quantity:</span>
                            <span>{{ $product->quantity }}</span>
                        </div>
                        <div>
                            <span class="uk-text-bold">Price :</span>
                            <span class="uk-text-bold uk-margin-small-right sdetail-price">
                                ₹{{ sprintf('%.2f', $product->price) }}
                            </span>
                            <span class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                                ₹{{ sprintf('%.2f', $product->price / (1 - $product->discount)) }}</span>
                            <span class="uk-inline uk-text-lowercase">per {{ $product->unit }}</span>
                        </div>

                        <span class="uk-text-small uk-text-bold uk-text-danger uk-margin-right sdetail-offer">(You Save :
                            {{ $product->discount * 100 }}%)</span>
                    </div>
                    {{-- <p class="uk-text-large uk-margin-remove">_</p> --}}
                    <hr />
                    <div class="uk-margin-small-top uk-margin-small-bottom">{!! $product->desc !!}</div>
                </div>

                <div class="uk-card-footer uk-width-1-1 uk-flex uk-flex-row uk-flex-center">
                    <a href="/product_edit/{{ $product->id }}" type=" button"
                        class="uk-margin-right uk-link-heading uk-text-primary uk-text-bold">Edit</a>

                    <form action="{{ route('product.destroy', $product->id) }}" id="removeProduct" method="post">
                        @csrf
                        <a href="#" onclick="document.getElementById('removeProduct').submit()"
                            class="uk-margin-left uk-link-heading sdetail-remove uk-text-danger uk-text-bold">Remove</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
