@extends('layouts.app')

@section('content')
    <section class="uk-height-1-1 uk-padding-small sprod">
        {{-- <a class="uk-button uk-button-default" href="{{ route('product.create') }}"> <i class="ri-add-fill"></i> Add New
            Product</a> --}}
        <div
            class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-around uk-padding-remove-bottom uk-padding-remove-horizontal">
            @if (count($products) > 0)
                @foreach ($products as $prod)
                    <div
                        class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-flex
                                                                                                                                                                             uk-flex-column uk-flex-between uk-margin-large-bottom uk-margin-right uk-margin-left">
                        <a href="{{ route('seller.product.view', $prod->slug) }}" class="uk-flex uk-flex-center">
                            <img src="{{ isset($prod->coverPhotos) ? asset('uploads/products/' . $prod->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                uk-img />
                        </a>
                        <div class="uk-padding-small">
                            <div class="uk-margin-small-bottom">
                                <span class="uk-text-bold">{{ $prod->type }}</span> |
                                <span style="font-family: cursive">{{ $prod->name }}</span>
                            </div>
                            <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                <span class="sprod-color">
                                    ₹ {{ $prod->price }}
                                </span>
                                per {{ $prod->unit }}
                                <div>{{ $prod->coverPhotos }}</div>
                            </div>
                            {{-- <div>{!! $prod->desc !!}</div> --}}
                        </div>
                        <div
                            class="uk-flex uk-flex-between uk-card-footer uk-padding-remove-bottom uk-padding-remove-horizontal">
                            @if (Auth::user()->role == 'customer')
                                <a href="/cart_add" type=" button" class="uk-text-primary">Add to Bag</a>
                            @elseif (Auth::user()->role == 'seller')
                                <a href="/cart_add" type=" button" class="uk-text-primary">Add</a>
                                <a href="/product_edit/{{ $prod->id }}" type=" button" class="uk-text-warning">Edit</a>
                                <a href="/product_destroy/{{ $prod->id }}" type=" button"
                                    class="uk-text-danger">Remove</a>
                            @elseif (Auth::user()->role == 'admin')
                                <a href="/product_edit/{{ $prod->id }}" type=" button" class="uk-text-warning">Edit</a>
                                <a href="/product_destroy/{{ $prod->id }}" type=" button"
                                    class="uk-text-danger">Remove</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p> No Products Uploaded</p>
            @endif
            <div
                class="uk-card uk-card-default uk-card-body uk-width-1-5@m uk-margin-large-bottom uk-margin-right uk-margin-left">
                <div class="uk-text-large uk-text-center uk-text-bold">Add New Product
                </div>
                <div class="uk-margin uk-padding-small uk-flex uk-flex-center sprod-add-new">
                    <a href="{{ route('product.create') }}"
                        class="uk-heading-small uk-text-muted uk-margin-remove uk-link-heading ri-add-circle-fill"></a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function post() {
            var x = {
                id: event.target.id
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/cart/store',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(x),
                success: function(data) {
                    console.log('Posted');
                }

            });
        }

    </script>
@endsection
