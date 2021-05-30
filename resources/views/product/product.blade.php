@extends('layouts.app')
@section('content')
    <div class="uk-height-1-1 uk-padding uk-flex uk-flex-around sdetail">
        <div class="uk-width-4-5@m uk-card uk-card-default uk-card-body uk-flex uk-flex-row uk-flex-middle">
            <div class="uk-width-1-2@m uk-padding-small uk-flex uk-flex-center">
                <img src={{ URL::to('/uploads/products/' . $product->cover) }} width="400px" height="400px" uk-img />
            </div>
            <div class="uk-width-1-2@m uk-padding-small">
                <div>
                    <span class="uk-text-large uk-text-emphasis uk-text-bold">{{ $product->name }}</span> ,
                    <span class="uk-text-emphasis uk-text-bold">{{ $product->unit }}</span>
                </div>

                <hr>
                <div class="uk-width-1-1@m uk-flex uk-flex-middle">

                    <span class="uk-text-bold uk-margin-small-right sdetail-price"> Price : ₹ {{ $product->price }}
                    </span>
                    <span class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                        {{ sprintf('%.2f', $product->price / (1 - $product->discount)) }}</span>
                    <span class="uk-text-small uk-text-bold uk-text-danger uk-margin-right sdetail-offer">(You Save :
                        {{ $product->discount * 100 }}%)</span>

                </div>
                <p class="uk-text-large uk-margin-remove">_</p>
                <div class="uk-margin-small-top uk-margin-small-bottom">{!! $product->desc !!}</div>
                <div>
                    <span class="uk-text-bold">Quantity</span>
                    <input class="uk-input uk-form-width-small uk-form-small uk-margin-left" type="number" name="qty">
                </div>
                <div class="uk-width-1-1 uk-flex uk-flex-around uk-margin">
                    <input class="uk-input uk-form-width-medium uk-text-center uk-text-bold" value="ADD TO BAG" disabled>
                </div>
                <div class="uk-width-1-1 uk-flex uk-flex-right">
                    <a href="/product_edit/{{ $product->id }}" type=" button"
                        class="uk-margin-right uk-link-heading uk-text-primary uk-text-bold">Edit</a>
                    <a href="/product_destroy/{{ $product->id }}" type=" button"
                        class="uk-margin-left uk-link-heading  sdetail-remove uk-text-danger uk-text-bold">Remove</a>
                </div>
            </div>
        </div>
    </div>

@endsection
