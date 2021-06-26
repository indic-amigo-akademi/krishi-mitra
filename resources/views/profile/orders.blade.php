@extends('layouts.app')

@section('content')
    <div class="uk-padding uk-flex uk-flex-middle uk-flex-column order-color">

        @if (count($orders) > 0)
            @foreach ($orders as $o)
                <div class="uk-width-4-5 uk-padding uk-margin-bottom order-card">
                    <div class="uk-flex uk-flex-row uk-flex-between uk-flex-wrap">

                        <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">
                            <img src="{{ isset($o->product->coverPhotos) ? asset('uploads/products/' . $o->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                width="100rem" uk-img class="uk-margin-right" />
                            <div class="uk-margin-left">
                                <div class="uk-text-bold uk-text-emphasis uk-margin-small-bottom">
                                    {{ $o->product->name }}
                                    ,
                                    {{ $o->product->type }} - 1 {{ $o->product->unit }}
                                </div>
                                <div class="uk-text-emphasis uk-margin-bottom">
                                    {{ $o->product->seller->trade_name }}
                                </div>
                                <div class="uk-text-bold uk-margin-small-bottom sdetail-price">
                                    ₹ {{ sprintf('%.2f', $o->total_discounted_price) }}
                                </div>
                            </div>
                        </div>

                        <div class="uk-margin-left">
                            <span class="uk-text-emphasis uk-text-bold"> Order ID: </span>
                            <a class="uk-text-bold"
                                href="{{ route('orders.show', $o->order_id) }}">{{ $o->order_id }}</a>
                            <br>
                            <span class="uk-text-emphasis"> Ordered On: </span><span>{{ $o->created_at }}</span>
                        </div>
                    </div>
                </div>

            @endforeach
            <a class="uk-button order-home" href="{{ route('product.browse') }}">Back To Home</a>
        @else
            <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                <p class="uk-text-bold uk-text-center">No Order History</p>
            </div>
        @endif
    </div>
@endsection
