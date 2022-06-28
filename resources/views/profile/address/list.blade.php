@extends('layouts.app')


@section('content')
    <section class="uk-margin-auto container">

        <div class="uk-flex uk-flex-center uk-padding-small">
            <div class="uk-width-2-3@m uk-card uk-card-default">
                @if (count($address) > 0)
                    <div class="uk-card-header uk-text-large uk-text-center uk-text-bold">Manage Addresses</div>
                    @foreach ($address as $addr)
                        <div class="uk-card-body uk-padding-small">
                            <form action="{{ route('address.edit.delete') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="uk-flex uk-flex-wrap uk-flex-between">
                                    <div class="uk-flex uk-flex-left@m uk-flex-wrap uk-flex-between">
                                        <div class="uk-margin-left">
                                            <span class="uk-text-bold">
                                                <i class="ri-checkbox-blank-circle-fill"></i>
                                                {{ $addr->name }}
                                            </span>
                                            <span class="checkout_add_type  uk-text-small">{{ $addr->type }}</span>
                                        </div>
                                        <div class="uk-margin-left uk-text-bold">{{ $addr->mobile }}</div>
                                        <input type="hidden" name="id" value="{{ $addr->id }}">
                                    </div>

                                    <div class="uk-flex uk-flex-right@m uk-flex-between">
                                        <button id='{{ $addr->id }}e' type="submit" name="type" value="edit"
                                            class="uk-align-right uk-button uk-button-link uk-text-primary uk-text-bold">
                                            <i class="ri-check-line"></i> Edit
                                        </button>
                                        <button id='{{ $addr->id }}d' type="submit" name="type" value="delete"
                                            class="uk-align-right uk-button uk-button-link uk-text-danger  uk-text-bold">
                                            <i class="ri-close-line"></i> Delete
                                        </button>
                                    </div>

                                </div>
                                <div class="uk-padding-small uk-padding-remove-top">
                                    <span>{{ $addr->address1 }}, </span>
                                    <span>{{ $addr->address2 }}, </span>
                                    <span>{{ $addr->landmark }}, {{ $addr->city }}, </span>
                                    <br>
                                    <span>{{ $addr->state }}, PIN: {{ $addr->pincode }}</span><br>
                                </div>
                            </form>
                        </div>
                    @endforeach


                @else
                    <div class="uk-card-body uk-padding-small">
                        <p> No Address Available</p>
                    </div>
                @endif
                <div class="uk-card-footer">
                    <a class="uk-link-heading uk-text-bold uk-padding-small text-theme-color1"
                        href="{{ route('address.add.view') }}">
                        <i class="ri-add-circle-line"></i> ADD NEW ADDRESS
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
