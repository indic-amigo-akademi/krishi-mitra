@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        <div class="uk-container">
            <div class="uk-card" uk-card-default>
                <div class="uk-card-header">
                    <h3 class="uk-card-title">{{ __('Admin Authentication') }}</h3>
                </div>
                <div class="uk-card-body">
                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
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
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
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

                </div>
                <div class="uk-card-footer">
                    <button type="submit" class="uk-button uk-button-primary">
                        Apply For Admin
                    </button>
                </div>
            </div>
        </div>
        <br>
    </form>
@endsection
