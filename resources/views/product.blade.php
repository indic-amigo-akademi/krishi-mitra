@extends('layouts.app')
@section('content')
    <div class="uk-height-1-1 uk-padding uk-flex uk-flex-around sdetail">
        <div
            class="uk-width-4-5@m uk-card uk-card-default uk-padding-remove-vertical uk-card-body uk-flex uk-flex-row uk-flex-middle uk-flex-wrap">

            <div class="uk-width-1-2@m uk-padding-small uk-flex uk-flex-column uk-flex-center">
                <div class="uk-flex uk-flex-row  uk-flex-center uk-flex-wrap">
                    @foreach ($product->coverPhotos as $photo)
                        <div class="uk-margin-left uk-margin-right product_box">
                            <img src="{{ asset('uploads/products/' . $photo->name) }}" width="80px" uk-img />
                        </div>
                    @endforeach
                </div>
                <img src="{{ isset($product->coverPhotos) ? asset('uploads/products/' . $product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                    width="400px" height="400px" uk-img />
            </div>
            <div class="uk-width-1-2@m uk-padding-small">
                <div>
                    <span class="uk-text-large uk-text-emphasis uk-text-bold">{{ $product->name }}</span> ,
                    <span class="uk-text-emphasis uk-text-bold">{{ $product->unit }}</span>
                </div>

                <hr>
                <div class="uk-width-1-1@m uk-flex uk-flex-middle">

                    <span class="uk-text-bold uk-margin-small-right"><span class="sdetail-price"> Price :</span>
                        ₹ {{ $product->price }}
                    </span>
                    <span class="uk-text-muted uk-text-small uk-padding-large-left uk-margin-right sdetail-mrp">
                        {{ sprintf('%.2f', $product->price / (1 - $product->discount)) }}</span>
                    <span class="uk-text-small uk-text-bold uk-text-danger uk-margin-right sdetail-offer">(You Save :
                        {{ $product->discount * 100 }}%)</span>

                </div>
                <div class="uk-margin-small-top uk-margin-small-bottom">
                    <span class="uk-text-bold">Quantity</span>
                    <input class="uk-input uk-form-width-small uk-form-small uk-margin-left" type="number" name="qty"
                        value=1>
                </div>
                <p class="uk-text-large uk-margin-remove">_</p>
                <div class="uk-margin-top uk-text-bold">Description</div>
                <div class="uk-margin-small-bottom">{!! $product->desc !!}</div>

                <div class="uk-width-1-1 uk-flex uk-flex-row uk-flex-between uk-margin-top">
                    <a class="uk-button uk-button-default uk-text-bold prod_button" href="#"
                        onclick="addToCart('{{ $product->id }}')">Add</a>
                    <a class="uk-button uk-button-default uk-text-bold prod_button" href="#"
                        onclick="buyNow('{{ $product->id }}')">Buy
                        Now</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function addToCart(id) {
            event.preventDefault();
            @if (Auth::check())
                let x = {
                id: id
                }
                /*$.ajaxSetup({
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
                });*/
                fetch('/cart/store', {
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(x),
                method: 'post',
                }).then(function(response) {
                console.log('Posted');
                location.reload();
                }).catch(function(error) {
                console.error('Error:', error);
                });
            @else
                UIkit.modal($("#signin-form").get(0)).show();
            @endif
        }

        function buyNow(id) {
            @if (Auth::check())
                location.href = "{{ route('checkout_buynow', '') }}/"+id;
            @else
                UIkit.modal($("#signin-form").get(0)).show();
            @endif
        }

    </script>
@endsection
