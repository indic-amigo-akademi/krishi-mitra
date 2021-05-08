@extends('layouts.app')

@section('content')
    <div class="uk-container">
        <div class="uk-flex uk-flex-center" uk-grid>
            <div class="col-md-8">
                <div class="uk-card">
                    <div class="uk-card-header">
                        <h3 class="uk-card-title uk-text-center">{{ __('Register') }}</h3>
                    </div>

                    <div class="uk-card-body">
                        <form class="uk-form-stacked" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="uk-form-label">{{ __('Name') }}</label>

                                <div class="uk-form-controls">
                                    <input id="name" type="text" class="uk-input @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username"
                                    class="uk-form-label">{{ __('User-Name') }}</label>

                                <div class="uk-form-controls">
                                    <input id="username" type="text"
                                        class="uk-input @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username">

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="uk-form-label">{{ __('Email') }}</label>

                                <div class="uk-form-controls">
                                    <input id="email" type="text" class="uk-input @error('email') is-invalid @enderror"
                                        name="email" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone"
                                    class="uk-form-label">{{ __('Phone-Number') }}</label>

                                <div class="uk-form-controls">
                                    <input id="phone" type="number"
                                        class="uk-input @error('phone') is-invalid @enderror" name="phone" required
                                        autocomplete="new-phone">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="uk-form-label">{{ __('Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password" type="password"
                                        class="uk-input @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="uk-form-label">{{ __('Confirm Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password-confirm" type="password" class="uk-input"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="uk-margin-small-top uk-text-center">
                                    <button type="submit" class="uk-button uk-button-primary">
                                        {{ __('Register') }}
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
