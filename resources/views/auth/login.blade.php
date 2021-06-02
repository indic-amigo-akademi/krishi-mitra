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
                        <form class="uk-form-stacked" method="POST" action="{{ route('login') }}" id="web-login-form">
                            @csrf

                            <div class="">
                                <label for="email" class="uk-form-label">{{ __('E-Mail Address') }}</label>

                                <div class="uk-form-controls">
                                    <input id="email" type="email" class="uk-input @error('email') uk-form-danger @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    {{-- @error('email')
                                        <div class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror --}}

                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-email"></strong>
                                    </small>
                                </div>
                            </div>

                            <div class="">
                                <label for="password" class="uk-form-label">{{ __('Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password" type="password"
                                        class="uk-input @error('password') uk-form-danger @enderror" name="password"
                                        required autocomplete="current-password">

                                    {{-- @error('password')
                                        <div class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror --}}

                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-password"></strong>
                                    </small>
                                </div>
                            </div>

                            <div class="">
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

                            <div class=" mb-0">
                                <div class="uk-margin-small-top">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            <small>{{ __('Forgot Your Password?') }}</small>
                                        </a>
                                    @endif

                                </div>
                                <div class="uk-margin-small-top uk-text-center">
                                    <button type="button" class="uk-button uk-button-primary"
                                        onClick="validateLoginForm(event)">
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

@section('scripts')
    <script>
        async function validateLoginForm(event) {
            try {
                $(event.target).text("{{ __('Processing') }}...");
                const formData = new FormData($('#web-login-form').get(0));

                event.preventDefault();
                const response = await fetch('{{ route('user.login.validate') }}', {
                    method: 'POST',
                    body: formData
                });
                const jsonData = await response.json();
                console.log(jsonData);

                $(event.target).text("{{ __('Login') }}");

                if (jsonData.success) {
                    $('#web-login-form').submit();
                } else {
                    Object.keys(jsonData.errors).forEach((ele) => {
                        $(`#web-login-form .uk-text-danger strong.error-${ele}`).text(jsonData.errors[ele]);
                    });
                }
            } catch (err) {
                console.log("Cannot Connect to Server")
            }
        }

    </script>
@endsection
