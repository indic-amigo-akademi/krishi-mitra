@extends('layouts.app')

@section('content')

    <div class="uk-container">
        <div class="uk-card" uk-card-default>
            <div class="uk-card-header">
                <h3 class="uk-card-title">Admin Dashboard</h3>
            </div>
            <div class="uk-card-body">
                <ul class="uk-list links">
                    <li><a href="{{ route('admin.approval.view') }}">Approve Requests</a></li>
                    <li><a href="{{ route('product.browse') }}">Browse products</a></li>
                </ul>
            </div>
            <div class="uk-card-footer"></div>
        </div>
    </div>

@endsection
