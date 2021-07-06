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
                            <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@l uk-flex-left">
                                @include('components.productBox')
                            </div>
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
