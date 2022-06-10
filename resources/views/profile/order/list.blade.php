@extends('layouts.app')

@section('content')
    <section class="container orders-container">
        <div class="uk-padding uk-flex uk-flex-middle uk-flex-column">
            <div class="uk-width-1-1 uk-width-2-3@m">
                <h1 class="uk-text-large uk-text-bold uk-text-uppercase text-theme-color1 uk-card-title">My Orders</h1>
                <hr />

                @if (count($orders) > 0)
                    @foreach ($orders as $order)
                        <div class="uk-padding-small uk-margin-bottom order-card">
                            <div class="uk-flex uk-flex-row uk-flex-between uk-flex-wrap">

                                <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">
                                    <img src="{{ isset($order->product->coverPhotos) && count($order->product->coverPhotos) > 0 ? asset('uploads/products/' . $order->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                        width="100rem" uk-img class="uk-margin-right" />
                                    <div class="uk-margin-left">
                                        <div class="uk-text-bold uk-text-emphasis uk-margin-small-bottom">
                                            {{ $order->product->name }}
                                            ,
                                            {{ $order->product->category }} - 1 {{ $order->product->unit }}
                                        </div>
                                        <div class="uk-text-emphasis uk-margin-small-bottom">
                                            {{ $order->product->seller->trade_name }}
                                        </div>
                                        <div class="uk-text-bold uk-margin-small-bottom sdetail-price">
                                            ₹ {{ sprintf('%.2f', $order->total_discounted_price) }}
                                            <span
                                                class="uk-text-muted uk-text-strikethrough uk-text-small uk-margin-small-left">
                                                ₹ {{ sprintf('%.2f', $order->total_price) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-margin-left">
                                    <span class="uk-text-emphasis uk-text-bold"> Order ID: </span>
                                    <a class="uk-text-bold"
                                        href="{{ route('orders.show', $order->order_id) }}">{{ $order->order_id }}</a>
                                    <br>
                                    <span class="uk-text-emphasis"> Ordered On:
                                    </span><span>{{ $order->created_at }}</span>
                                    <br>
                                    <span class="uk-text-emphasis">Order Status : </span>
                                    <span>{{ $order->status }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $orders->links() }}
                @else
                    <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                        <p class="uk-text-bold uk-text-center">No Order History</p>
                    </div>
                @endif
                <a class="uk-button order-home" href="{{ route('home') }}">
                    <span uk-icon="icon:  chevron-double-left"></span> Back To Home
                </a>
            </div>
        </div>
    </section>
@endsection
