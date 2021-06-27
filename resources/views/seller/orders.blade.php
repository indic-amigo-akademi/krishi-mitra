@extends('layouts.app')

@section('content')
    <div class="uk-padding uk-flex uk-flex-middle uk-flex-column order-color">

        @if (count($products) > 0)
            @foreach ($products as $o)
                <div class="uk-width-4-5 uk-padding uk-margin-bottom order-card">
                    <div class="uk-flex uk-flex-row uk-flex-between uk-flex-wrap">

                        <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-around  uk-flex-wrap">

                            <div class="uk-margin-left">
                                <div class="uk-text-bold uk-text-emphasis uk-margin-small-bottom">
                                    Name: {{ $o->name }}
                                    ,
                                    Product_id:{{ $o->id }}
                                </div>
                                <div class="uk-text-emphasis uk-margin-bottom">
                                    Quantity Purchased:{{ $o->qty }} ,
                                    Price:{{ $o->price }}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        @else
            <div class="uk-card uk-card-default uk-padding uk-margin-bottom">
                <p class="uk-text-bold uk-text-center">No Order History</p>
            </div>
        @endif
    </div>
@endsection
