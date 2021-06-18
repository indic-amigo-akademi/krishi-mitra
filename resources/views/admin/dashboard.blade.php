@extends('layouts.app')

@section('content')

    <div class="uk-width-1-1 uk-height-1-1 uk-background-cover uk-background-norepeat uk-padding-small"
        style="background-image:url({{ asset('images/background/img7.jpg') }})">

        <div class="uk-card uk-container uk-card-default">
            <div class="uk-card-header">
                <h3 class="uk-card-title">Admin Dashboard</h3>
            </div>
            <div class="uk-card-body">
                <ul class="uk-list links">
                    @if (Auth::user()->is_sysadmin)
                        <li><a href="{{ route('admin.browse.view') }}">Browse admins</a></li>
                    @endif
                    <li><a href="{{ route('admin.product.browse') }}">Browse products</a></li>
                    <li><a href="{{ route('admin.approval.view') }}">Approve Requests</a></li>
                </ul>
            </div>
            <div class="uk-card-footer"></div>
        </div>
    </div>

@endsection
