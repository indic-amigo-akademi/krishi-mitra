@extends('layouts.app')


@section('content')
    <div class="uk-width-1-1 uk-padding-large uk-flex uk-flex-center cart_bag">

        @if (count($address) > 0)
            <div class="uk-width-2-3@m uk-card uk-card-default uk-padding">
                <div class="uk-card-header uk-text-large uk-text-center uk-text-bold">Manage Addresses</div>
                @foreach ($address as $addr)
                    <form action="{{ route('address.edit.delete') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="uk-padding-small uk-margin-small-top">
                                <div>
                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                    <span class="uk-text-bold uk-margin-left">{{ $addr->name }}</span>
                                    <span class="uk-margin-left uk-text-small checkout_add_type">{{ $addr->type }}</span>
                                    <span class="uk-text-bold uk-margin-left">{{ $addr->mobile }}</span>
                                    <input type="hidden" name="id" value="{{ $addr->id }}">
                                </div>

                                <div>
                                    <button id='{{ $addr->id }}e' type="submit" name="input" value="Edit"
                                        class="uk-align-right uk-button uk-button-link uk-text-primary uk-text-bold">
                                        <i class="ri-check-line"></i> Edit
                                    </button>
                                    <button id='{{ $addr->id }}d' type="submit" name="input" value="Delete"
                                        class="uk-align-right uk-button uk-button-link uk-text-danger  uk-text-bold">
                                        <i class="ri-close-line"></i> Delete
                                    </button>
                                </div>

                            </div>
                            <div class="uk-padding-small uk-padding-remove-top uk-padding-remove-left uk-margin-large-left">
                                <span>{{ $addr->address1 }}, </span>
                                <span>{{ $addr->address2 }}, </span>
                                <span>{{ $addr->landmark }}, {{ $addr->city }}, </span>
                                <br>
                                <span>{{ $addr->state }}, PIN: {{ $addr->pincode }}</span><br>
                            </div>
                        </div>
                    </form>
                @endforeach

                <a class="uk-link-heading uk-margin-left uk-text-bold uk-flex uk-flex-middle uk-padding-small add_color"
                    href="{{ route('address.add.view') }}" style="color: #3b7402"><i class="ri-add-circle-line"> </i>
                    ADD NEW ADDRESS</a>

            </div>
        @else
            <p> No Address Available</p>
            <br>

        @endif
    </div>
@endsection
