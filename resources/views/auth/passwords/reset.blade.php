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
                        <form class="uk-form-stacked" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="">
                                <label for="email" class="uk-form-label">{{ __('E-Mail Address') }}</label>

                                <div class="uk-form-controls">
                                    <input id="email" type="email" class="uk-input @error('email') uk-form-danger @enderror"
                                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                        autofocus>

                                    @error('email')
                                        <div class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <label for="password" class="uk-form-label">{{ __('Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password" type="password"
                                        class="uk-input @error('password') uk-form-danger @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <div class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <label for="password-confirm" class="uk-form-label">{{ __('Confirm Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password-confirm" type="password" class="uk-input"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="uk-margin-small-top uk-text-center">
                                <button type="submit" class="uk-button uk-button-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
