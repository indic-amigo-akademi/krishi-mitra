@extends('layouts.app')

@section('content')
    <section class="container order-container">
        <div class="uk-padding uk-flex uk-flex-middle uk-flex-column order-color">
            <div class="uk-width-1-1 uk-width-2-3@m">
                <h1 class="uk-text-large uk-text-bold uk-text-uppercase text-theme-color1">Order Details</h1>
                <hr>

                @if (count($orders) > 0)
                    @foreach ($orders as $order)
                        <div class="uk-padding-small uk-flex uk-flex-row uk-flex-between uk-flex-wrap order-card">
                            <div>
                                {{-- <div class="uk-text-emphasis uk-text-bold uk-margin-top uk-margin-bottom">ORDER DETAILS</div> --}}
                                <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">
                                    <img src="{{ isset($order->product->coverPhotos) && count($order->product->coverPhotos) > 0 ? asset('uploads/products/' . $order->product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                        width="100rem" uk-img class="uk-margin-right" />
                                    <div class="">
                                        <div class="uk-text-bold uk-text-emphasis">
                                            {{ $order->product->name }}
                                            ,
                                            {{ $order->product->category }} - 1 {{ $order->product->unit }}
                                        </div>
                                        <div class="uk-text-emphasis uk-margin-small-bottom">
                                            {{ $order->product->seller->trade_name }}
                                        </div>
                                        <div class="uk-text-bold uk-margin-small-bottom sdetail-price">
                                            ₹{{ sprintf('%.2f', $order->total_discounted_price) }}
                                            <span
                                                class="uk-text-muted uk-text-strikethrough uk-text-small uk-margin-small-left">
                                                ₹ {{ sprintf('%.2f', $order->total_price) }}
                                            </span>
                                        </div>
                                        <div class="uk-text-small uk-margin-bottom">
                                            Quantity : {{ $order->qty }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                {{-- <div class="uk-text-bold uk-text-emphasis  uk-margin-top uk-margin-bottom">ADDRESS DETAILS
                        </div> --}}
                                <div>
                                    <span class="uk-text-bold">{{ $order->address->name }}</span>
                                    <br>
                                    <span class="uk-text-emphasis">Phone : {{ $order->address->mobile }}</span>
                                    <br>
                                    <span>{{ $order->address->full_address }}</span>
                                    <br>
                                    <span class="uk-text-emphasis">Ordered on : </span>
                                    {{ $order->created_at }}
                                    <br>
                                    <span class="uk-text-emphasis">Order Status : {{ $order->status }}</span>
                                </div>
                                
                            </div>
                            <form action="{{ route('orders.show.cancel.delete',$order->order_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id" name="id" value ="{{ $order->id }}">
                                @if($order->status=="Processed")
                                    <button id='{{ $order->id }}c' type="submit" name="input" value="Cancel"
                                        class="uk-align-right uk-button uk-button-link uk-text-danger  uk-text-bold">
                                        <i class="ri-close-line"></i> Cancel Order
                                    </button>                     
                                @else
                                    <button id='{{ $order->id }}c' type="submit" name="input" value="Delete"
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
                <br> 
                <a class="uk-button order-home" href="{{ route('orders') }}">
                    <span uk-icon="icon:  chevron-double-left"></span> Back To Orders
                </a>
            </div>
        </div>
    </section>
@endsection
