@extends('layouts.app')

@section('content')
    <section class="container order-container">
        <div class="uk-padding uk-flex uk-flex-middle uk-flex-column order-color">
            <div class="uk-width-1-1 uk-width-2-3@m">
                <h1 class="uk-text-large uk-text-bold uk-text-uppercase text-theme-color1">Order Details</h1>
                <hr>

                @if (count($orders) > 0)
                    @foreach ($orders as $o)
                        <div class="uk-padding-small uk-flex uk-flex-row uk-flex-between uk-flex-wrap order-card">
                            <div>
                                {{-- <div class="uk-text-emphasis uk-text-bold uk-margin-top uk-margin-bottom">ORDER DETAILS</div> --}}
                                <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">
                                    <img src="{{ isset($o->product->coverPhotos) ? asset('uploads/products/' . $o->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                        width="100rem" uk-img class="uk-margin-right" />
                                    <div class="">
                                        <div class="uk-text-bold uk-text-emphasis">
                                            {{ $o->product->name }}
                                            ,
                                            {{ $o->product->category }} - 1 {{ $o->product->unit }}
                                        </div>
                                        <div class="uk-text-emphasis uk-margin-small-bottom">
                                            {{ $o->product->seller->trade_name }}
                                        </div>
                                        <div class="uk-text-bold uk-margin-small-bottom sdetail-price">
                                            ₹{{ sprintf('%.2f', $o->total_discounted_price) }}
                                            <span
                                                class="uk-text-muted uk-text-strikethrough uk-text-small uk-margin-small-left">
                                                ₹ {{ sprintf('%.2f', $o->total_price) }}
                                            </span>
                                        </div>
                                        <div class="uk-text-small uk-margin-bottom">
                                            Quantity : {{ $o->qty }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                {{-- <div class="uk-text-bold uk-text-emphasis  uk-margin-top uk-margin-bottom">ADDRESS DETAILS
                        </div> --}}
                                <div>
                                    <span class="uk-text-bold">{{ $o->address->name }}</span>
                                    <br>
                                    <span class="uk-text-emphasis">Phone : {{ $o->address->mobile }}</span>
                                    <br>
                                    <span>{{ $o->address->full_address }}</span>
                                    <br>
                                    <span class="uk-text-emphasis">Ordered on : </span>
                                    {{ $o->created_at }}
                                    <br>
                                    <span class="uk-text-emphasis">Order Status : {{ $o->status }}</span>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                        <p class="uk-text-bold uk-text-center">No Order History</p>
                    </div>
                @endif
                <br>
                <a class="uk-button order-home" href="{{ route('orders') }}">
                    <span uk-icon="icon:  chevron-double-left"></span> Back To Orders
                </a>
            </div>
        </div>
    </section>
@endsection
