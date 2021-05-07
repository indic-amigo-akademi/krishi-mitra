@extends('layouts.app')

@section('content')

    <section class="container">
        <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light header-content"
            data-src="{{ asset('images/background/img2.jpeg') }}" uk-img>

            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">{{ config('app.name') }}</h3>
                </div>

                <div class="uk-card-body"></div>

            </div>
        </div>
    </section>
@endsection
