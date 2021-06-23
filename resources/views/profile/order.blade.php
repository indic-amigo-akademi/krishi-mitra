@extends('layouts.app')

@section('content')
    <div class="uk-padding uk-flex uk-flex-middle uk-flex-column order-color">
        @if (count($orders) > 0)
            @foreach ($orders as $o)
                <div
                    class="uk-width-4-5 uk-padding uk-padding-remove-vertical uk-flex uk-flex-row uk-flex-between uk-flex-wrap order-card">
                    <div>
                        <div class="uk-text-emphasis uk-text-bold uk-margin-top uk-margin-bottom">ORDER DETAILS</div>
                        <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">
                            <img src="{{ isset($o->product->coverPhotos) ? asset('uploads/products/' . $o->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                width="100rem" uk-img class="uk-margin-right" />
                            <div class="uk-margin-left">
                                <div class="uk-text-bold uk-text-emphasis">
                                    {{ $o->product->name }}
                                    ,
                                    {{ $o->product->type }} - 1 {{ $o->product->unit }}
                                </div>
                                <div class="uk-text-emphasis uk-margin-small-bottom">
                                    {{ $o->product->seller->trade_name }}
                                </div>
                                <div class="uk-text-bold uk-margin-small-bottom sdetail-price">
                                    ₹{{ sprintf('%.2f', $o->total_discounted_price) }}</div>
                                <div class="uk-text-small uk-margin-bottom">
                                    Quantity : {{ $o->qty }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="uk-text-bold uk-text-emphasis  uk-margin-top uk-margin-bottom">ADDRESS DETAILS
                        </div>
                        <div>
                            <span class="uk-text-bold">{{ $o->address->name }}</span>
                            <br>
                            <span class="uk-text-emphasis">Phone : {{ $o->address->mobile }}</span>
                            <br>
                            <span>{{ $o->address->full_address }}</span>
                            <br>
                            <span class="uk-text-emphasis">Ordered on : {{ $o->created_at }}</span>
                            <br>
                            <span class="uk-text-emphasis">Order Status : {{ $o->status }}</span>
                        </div>
                    </div>
                    <form action="{{ route('orders.show.cancel.delete',$o->order_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value ="{{ $o->id }}">
                        @if($o->status=="Processed")
                            <button id='{{ $o->id }}c' type="submit" name="input" value="Cancel"
                                class="uk-align-right uk-button uk-button-link uk-text-danger  uk-text-bold">
                                <i class="ri-close-line"></i> Cancel Order
                            </button>                     
                        @else
                            <button id='{{ $o->id }}c' type="submit" name="input" value="Delete"
                                class="uk-align-right uk-button uk-button-link uk-text-danger  uk-text-bold">
                                <i class="ri-close-line"></i> Delete Order
                            </button>    
                        @endif
                    </form>
                </div>
            @endforeach
        @else
            <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                <p class="uk-text-bold uk-text-center">No Order History</p>
            </div>
        @endif
    </div>
@endsection
