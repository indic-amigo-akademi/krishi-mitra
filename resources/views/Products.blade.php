@extends('layouts.app')
@section('content')
    <h1>List of all products</h1>
    @if (count($products) > 0)
        @foreach ($products as $prod)
            <h2>{{ $prod->name }}</h2>
            <img src={{ URL::to('/uploads/products/' . $prod->cover) }}>

        @endforeach
    @else
        NO PRODUCTS FOUND
    @endif
@endsection
