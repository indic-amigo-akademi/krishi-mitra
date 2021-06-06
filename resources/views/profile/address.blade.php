@extends('layouts.app')


@section('content')
    @if (count($address) > 0)
        @foreach ($address as $addr)
        <form action="{{ route('address.edit.delete') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <div>
                    <span class="uk-text-bold">{{ $addr->name }}</span>
                </div>
                <div>
                    <span style="font-family: cursive">{{ $addr->mobile }}</span>
                </div>
                <div>
                    <span>{{ $addr->address1 }},</span><br>
                    <span>{{ $addr->address2 }},</span><br>
                    <span>{{ $addr->landmark }},{{ $addr->city }},{{ $addr->state }},</span><br>
                    <span>PIN: {{ $addr->pincode }}</span><br>
                </div>
                <div>
                    <span class="uk-text-bold">{{ $addr->type }}</span>
                </div>
                <div>
                    <input type="hidden" name="id" value="{{ $addr->id }}">
                    <button id='{{ $addr->id }}e' type="submit" name="input" value="Edit"
                        class="uk-button uk-button-link uk-text-primary">
                        <i class="ri-check-line"></i> Edit
                    </button>
                    <button id='{{ $addr->id }}d' type="submit" name="input" value="Delete"
                        class="uk-button uk-button-link uk-text-danger">
                        <i class="ri-close-line"></i> Delete
                    </button>
                </div>
            </div>
        </form>
        @endforeach
    @else
        <p> No Address Available</p>
        <br>
        
    @endif
    <li><a href="{{ route('address.add.view') }}">Add Address</a></li>
@endsection