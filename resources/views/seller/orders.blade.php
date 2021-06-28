@extends('layouts.app')

@section('content')
    <section class="container orders-container">
        <div class="uk-padding uk-flex uk-flex-middle uk-flex-column">
            <div class="uk-width-1-1 uk-width-2-3@m">
                <h1 class="uk-text-large uk-text-bold uk-text-uppercase text-theme-color1 uk-card-title">My Received Orders
                </h1>
                <hr />

                @if (count($orders) > 0)
                    @foreach ($orders as $o)
                        <div class="uk-padding-small uk-margin-bottom order-card">

                            <div class="uk-flex uk-flex-row uk-flex-between uk-flex-wrap">

                                <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">
                                    <a href="{{ route('seller.product.view', $o->product->slug) }}"
                                        class="uk-margin-right">
                                        <img src="{{ isset($o->product->coverPhotos) ? asset('uploads/products/' . $o->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                            width="100rem" uk-img />
                                    </a>
                                    <div class="uk-margin-left">
                                        <div class="uk-text-bold uk-text-emphasis">
                                            <a href="{{ route('seller.product.view', $o->product->slug) }}"
                                                class="text-theme-color2">
                                                <span style="font-family: monospace">
                                                    {{ $o->product->name }}
                                                </span>
                                            </a>
                                            ,
                                            <a href="{{ route('explore') . '?c=' . $o->product->type }}"
                                                class="text-theme-color2">
                                                <span class="uk-text-bold">{{ $o->product->category }}</span>
                                            </a> - {{ $o->qty . ' ' . $o->product->unit }}
                                        </div>
                                        <div class="uk-text-emphasis uk-margin-small-bottom">
                                            <a href="{{ route('explore') . '?s=' . $o->product->seller->id }}">
                                                {{ $o->product->seller->trade_name }}
                                            </a>
                                        </div>
                                        <div class="uk-text-bold uk-margin-small-bottom sdetail-price">
                                            ₹ {{ sprintf('%.2f', $o->total_discounted_price) }}
                                            <span
                                                class="uk-text-muted uk-text-strikethrough uk-text-small uk-margin-small-left">
                                                ₹ {{ sprintf('%.2f', $o->total_price) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-margin-left">
                                    <span class="uk-text-emphasis uk-text-bold"> Order ID: </span>
                                    <a class="uk-text-bold"
                                        href="{{ route('seller.order.view', $o->order_id) }}">{{ $o->order_id }}</a>
                                    <br>
                                    <span class="uk-text-emphasis"> Ordered On:
                                    </span><span>{{ $o->created_at }}</span>
                                </div>
                            </div>
                        </div>

                    @endforeach
                    {{ $orders->links() }}
                @else
                    <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                        <p class="uk-text-bold uk-text-center">You have not orders yet</p>
                    </div>
                @endif
                <a class="uk-button order-home" href="{{ route('seller.index') }}">
                    <span uk-icon="icon:  chevron-double-left"></span> Back To Dashboard
                </a>
            </div>
        </div>
    </section>
@endsection
