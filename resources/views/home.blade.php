@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light header-content"
            data-src="{{ asset('images/background/img1.jpg') }}" uk-img>

            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">{{ __('Dashboard') }}</h3>
                </div>

                <div class="uk-card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        {{ Auth::user()->is_admin }}
                    </p>

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </section>
@endsection
