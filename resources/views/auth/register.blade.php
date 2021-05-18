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
                        <form class="uk-form-stacked" method="POST" action="{{ route('register') }}"
                            id="web-register-form">
                            @csrf

                            <div class="form-group row uk-child-width-auto">
                                <label for="name" class="uk-form-label">{{ __('Name') }}</label>

                                <div class="uk-form-controls">
                                    <input id="name" type="text" class="uk-input @error('name') uk-form-danger @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-name"></strong>
                                    </small>
                                    {{-- @error('name')
                                        <span class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="form-group row uk-child-width-auto">
                                <label for="username" class="uk-form-label">{{ __('Username') }}</label>

                                <div class="uk-form-controls">
                                    <input id="username" type="text"
                                        class="uk-input @error('username') uk-form-danger @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username">


                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-username"></strong>
                                    </small>
                                    {{-- @error('username')
                                        <span class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="form-group row uk-child-width-auto">
                                <label for="phone" class="uk-form-label">{{ __('Phone-Number') }}</label>

                                <div class="uk-form-controls">
                                    <input id="phone" type="number"
                                        class="uk-input pk-input-number @error('phone') uk-form-danger @enderror"
                                        name="phone" required autocomplete="new-phone">

                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-phone"></strong>
                                    </small>
                                    {{-- @error('phone')
                                        <span class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="form-group row uk-child-width-auto">
                                <label for="email" class="uk-form-label">{{ __('Email') }}</label>

                                <div class="uk-form-controls">
                                    <input id="email" type="text" class="uk-input @error('email') uk-form-danger @enderror"
                                        name="email" required autocomplete="email">

                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-email"></strong>
                                    </small>
                                    {{-- @error('email')
                                        <span class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>


                            <div class="form-group row uk-child-width-auto">
                                <label for="password" class="uk-form-label">{{ __('Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password" type="password"
                                        class="uk-input @error('password') uk-form-danger @enderror" name="password"
                                        required autocomplete="new-password">

                                    <small class="uk-text-danger uk-margin-bottom">
                                        <strong class="error-password"></strong>
                                    </small>
                                    {{-- @error('password')
                                        <span class="uk-alert-danger" uk-alert>
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="form-group row uk-child-width-auto">
                                <label for="password-confirm" class="uk-form-label">{{ __('Confirm Password') }}</label>

                                <div class="uk-form-controls">
                                    <input id="password-confirm" type="password" class="uk-input"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>


                            <div class="form-group row uk-child-width-auto mb-0">
                                <div class="uk-margin-small-top uk-text-center">
                                    <button type="button" class="uk-button uk-button-primary"
                                        onClick="validateRegisterForm(event)">
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


@section('scripts')
    <script>
        async function validateRegisterForm(event) {
            try {
                $(event.target).text("{{ __('Processing') }}...");
                const formData = new FormData($('#web-register-form').get(0));
                event.preventDefault();
                const response = await fetch('{{ route('user.register.validate') }}', {
                    method: 'POST',
                    body: formData
                });
                const jsonData = await response.json();
                console.log(jsonData);

                $('#web-register-form .uk-text-danger strong').text("");

                $(event.target).text("{{ __('Register') }}");

                if (jsonData.success) {
                    $('#web-register-form').submit();
                } else {
                    Object.keys(jsonData.errors).forEach((ele) => {
                        $(`#web-register-form .uk-text-danger strong.error-${ele}`).text(jsonData.errors[ele]);
                    });
                }
            } catch (err) {
                console.log("Cannot Connect to Server");
            }
        }

    </script>

@endsection
