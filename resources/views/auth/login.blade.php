@extends('layouts.app')

@section('content')
    <div class="uk-container">
        <div class="uk-flex uk-flex-center" uk-grid>
            <div class="">
                <div class="uk-card">
                    <div class="uk-card-header">
                        <h3 class="uk-card-title uk-text-center">{{ __('Login') }}</h3>
                    </div>

                    <div class="uk-card-body">
                        <form class="uk-form-stacked" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="uk-form-label">{{ __('E-Mail Address') }}</label>

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

                            <div class="form-group row">
                                <label for="password" class="uk-form-label">{{ __('Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password" type="password"
                                        class="uk-input @error('password') uk-form-danger @enderror" name="password" required
                                        autocomplete="current-password">

                                    @error('password')
                                        <div class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="uk-margin-small-top">
                                    <div class="form-check" uk-form-custom>
                                        <input class="uk-checkbox" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="uk-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="uk-margin-small-top">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif

                                </div>
                                <div class="uk-margin-small-top uk-text-center">
                                    <button type="submit" class="uk-button uk-button-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
