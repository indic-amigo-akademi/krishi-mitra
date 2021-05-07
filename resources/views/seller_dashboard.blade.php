@extends('layouts.app')

@section('content')
    <form action="/admin_dashboard" method="GET">

        <div class="content">
            <div class="title m-b-md">
                Krishi-Mitra
            </div>
            <div class="links">
                <a href="/products">Browse products</a>
                <a href="/create_product">Sell your produces</a>
            </div>
        </div>
    </form>
@endsection
