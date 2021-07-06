@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="uk-height-1-1 uk-flex uk-flex-wrap uk-flex-around">

            @if (count($products) > 0)
                <div class="product-slider uk-position-relative uk-visible-toggle uk-light uk-padding-small uk-margin-horizontal"
                    tabindex="-1" uk-slider="sets: true">
                    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-5@l uk-grid">
                        @foreach ($products as $product)
                            <li>
                                @include('components.productBox')
                            </li>
                        @endforeach
                    </ul>
                    <a class="uk-position-center-left uk-position-small slidenav" href="#" uk-slidenav-previous
                        uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small slidenav" href="#" uk-slidenav-next
                        uk-slider-item="next"></a>

                </div>
            @else
                <p> Products will be updated soon</p>
            @endif
        </div>
    </section>
@endsection
