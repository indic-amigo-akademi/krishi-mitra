@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="">
            <div class="uk-width-1-1 uk-width-1-4@l"></div>
            <div class="uk-padding-small uk-width-1-1 uk-width-3-4@l">
                <h2>{{ $page_title }}</h2>
                @if (count($products) > 0)
                    <div class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-left" style="max-width: 1200px;"
                        id="explore-results">
                        @foreach ($products as $product)
                            {{-- <div
                                class="uk-card uk-card-default uk-width-1-2 uk-width-1-3@s uk-width-1-4@l uk-flex-left product-box">
                                <div class="uk-card-media-top">
                                    <a href="{{ route('product.view', $prod->slug) }}" class="uk-flex uk-flex-center">
                                        <img src="{{ isset($prod->coverPhotos) ? asset('uploads/products/' . $prod->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                                            uk-img />
                                    </a>
                                </div>
                                <div class="uk-padding-remove">
                                    <div class="uk-card-body uk-padding-small">
                                        <div class="uk-margin-small-bottom">
                                            <a href="{{ route('product.view', $prod->slug) }}">
                                                <span style="font-family: cursive">{{ $prod->name }}</span>
                                            </a>
                                            |
                                            <a href="{{ route('explore') . '?c=' . $prod->type }}">
                                                <span class="uk-text-bold">{{ $prod->category }}</span>
                                            </a>
                                        </div>
                                        <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                                            <span class="sprod-color">
                                                ₹ {{ $prod->price }}
                                            </span>
                                            per {{ $prod->unit }}
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-flex uk-flex-between uk-card-footer uk-padding-small">
                                    <a href="#" onclick="addToCart('{{ $prod->id }}')" class="uk-text-primary">
                                        <i class="ri-shopping-bag-line"></i>
                                        <span class="icon-text">Add to Cart</span>
                                    </a>
                                    <a href="#" onclick="buyNow('{{ $prod->id }}')" class="uk-text-primary">
                                        <i class="ri-shopping-cart-line"></i>
                                        <span class="icon-text">Buy Now</span>
                                    </a>
                                </div>
                            </div> --}}
                            @include('components.productBox')
                        @endforeach
                    </div>
                    @if ($products->appends(request()->input())->hasMorePages())
                        <div class="uk-flex uk-flex-center uk-margin-small">
                            <a href="#" data-url="{{ $products->appends(request()->input())->nextPageUrl() }}"
                                class="uk-button uk-button-default bg-theme-color1 text-theme-color4 load-more-btn">Load
                                More...</a>
                        </div>
                    @endif
                @else
                    <p> Products will be updated soon</p>
                @endif

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('.load-more-btn').click(function(e) {
            e.preventDefault();
            let loadMoreBtn = $(this),
                url = $(this).data('url');
            if (url) {
                $.ajax({
                        url: url,
                        type: "get",
                        datatype: "html",
                        beforeSend: function() {
                            //$('.ajax-loading').show();
                        }
                    })
                    .done(function(data) {
                        data = JSON.parse(data);
                        if (data.success) {
                            //$('.ajax-loading').hide(); //hide loading animation once data is received
                            //notify user if nothing to load
                            $("#explore-results").append(data.data);
                            loadMoreBtn.data('url', data['next_url']);
                            if (!data['next_url']) {
                                loadMoreBtn.hide();
                            }
                            return;
                        }
                        //append data into #results element          
                        //$('.ajax-loading').html("No more records!");
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
            }

        });
    </script>
@endsection
