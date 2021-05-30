@extends('layouts.app')

@section('content')
    <form action="/admin_dashboard" method="GET">

        <div class="content">
            <div class="title m-b-md">
                Krishi-Mitra
            </div>
            <div class='login_details'>
                <h1>LOGIN DETAILS</h1>
                Name:{{ $usr->name }}<br>
                UserName:{{ $usr->username }}<br>
                Registered Email:{{ $usr->email }}<br>
                Registered Phone Number:{{ $usr->phone }}<br>


            </div>
            <div class="links">
                <a href="/seller/register">Register as Seller</a>
                <a href="/products">Browse products</a>
                <a href="https://blog.laravel.com">Talk to farmers</a>
            </div>
        </div>
    </form>
@endsection
