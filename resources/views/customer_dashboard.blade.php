@extends('layouts.app')

@section('content')
    <form action="/admin_dashboard" method="GET">

        <div class="content">
            <div class="title m-b-md">
                Krishi-Mitra
            </div>
            <div class="links">
                <a href="/seller_register">Register as Seller</a>
                <a href="/products">Browse products</a>
                <a href="https://blog.laravel.com">Talk to farmers</a>
            </div>
        </div>
    </form>
@endsection