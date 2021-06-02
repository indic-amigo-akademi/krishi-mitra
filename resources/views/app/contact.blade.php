@extends('layouts.app')

@section('content')
    <div class="uk-width-1-1 uk-height-1-1 uk-flex uk-flex-around uk-flex-middle contact ">
        <div class="uk-card uk-card-default uk-card-body uk-flex uk-flex-row uk-flex-wrap">
            <div class="uk-width-1-1 uk-width-1-3@m uk-padding-small uk-flex uk-flex-column uk-flex-center contact-card">
                <div class="uk-text-center uk-flex uk-flex-column">
                    <span class="ri-map-pin-fill"></span>
                    <p class="uk-text-bold uk-margin-remove uk-text-emphasis">Address</p>
                    <p class="uk-margin-remove-top uk-text-muted">Tarulia 2nd Lane Krishnaur, Kestopur, Kolkata, PIN-700102
                    </p>
                </div>
                <div class="uk-text-center uk-flex uk-flex-column">
                    <span class="ri-phone-fill"></span>
                    <p class="uk-text-bold uk-margin-remove uk-text-emphasis">Phone</p>
                    <p class="uk-margin-remove-top uk-text-muted">1800045678</p>
                </div>
                <div class="uk-text-center uk-flex uk-flex-column">
                    <span class="ri-mail-fill"></span>
                    <p class="uk-text-bold uk-margin-remove uk-text-emphasis">Email</p>
                    <p class="uk-margin-remove-top uk-text-muted">contact@zen-geeks.com</p>
                </div>
            </div>

            <div
                class="uk-width-1-1 uk-width-2-3@m uk-padding uk-padding-remove-top uk-padding uk-padding-remove-bottom uk-text-center">
                <div class="uk-text-large uk-text-bolder contact-text">Send us a Message</div>
                <div class="uk-margin uk-text-small uk-text-bold uk-text-emphasis">
                    Want to get in touch ? We would love to hear you. Here's how you can reach us.
                </div>
                <form id="web-contact-form" method="POST" action="{{ route('contact.create') }}">
                    @csrf
                    <div class="uk-margin">
                        <input class="uk-input @error('name') uk-form-danger @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required>
                        @error('name')
                            <div class="uk-alert-danger" uk-alert>
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <input class="uk-input @error('subject') uk-form-danger @enderror" type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject" required>
                        @error('subject')
                            <div class="uk-alert-danger" uk-alert>
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="uk-margin">
                        <textarea class="uk-textarea @error('message') uk-form-danger @enderror" rows="5" name="message" placeholder="Message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="uk-alert-danger" uk-alert>
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="uk-button contact-btn"><i class="ri-send-plane-fill"></i> Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
