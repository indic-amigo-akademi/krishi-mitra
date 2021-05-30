@extends('layouts.app')

@section('content')
    <div class="uk-container">
        <div class="uk-flex uk-flex-center" uk-grid>
            <div class="">
                <div class="uk-card">
                    <div class="uk-card-header">
                        <h3 class="uk-card-title uk-text-center">{{ __('Reset Password') }}</h3>
                    </div>

                    <div class="uk-card-body">
                        @if (session('status'))
                            <div class="uk-alert-success" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="uk-form-stacked" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="">
                                <label for="email"
                                    class="uk-form-label">{{ __('Email Address') }}</label>

                                <div class="uk-form-controls">
                                    <input id="email" type="email" class="uk-input @error('email') uk-form-danger @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <div class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="uk-margin-small-top uk-text-center">
                                <button type="submit" class="uk-button uk-button-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
