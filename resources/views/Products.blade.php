@extends('layouts.app')

@section('content')
    <h1>List of all products</h1>
    @if (count($data_arr[0]) > 0)
        <h1>{{ $data_arr[1] }}</h1>
        @foreach ($data_arr[0] as $prod)
            <h2>{{ $prod->type }}</h2>

            <img src={{ URL::to('/uploads/products/' . $prod->cover) }} width="300" height="300">
            @if ($data_arr[1] == 'customer')
                <button id={{ $prod->id }} onclick="post()">Add to cart</button>
            @endif
            @if ($data_arr[1] == 'seller')
                <button id={{ $prod->id }} onclick="post()">Add to cart</button>
                <a href="/product_edit/{{ $prod->id }}" type=" button" class="btn btn-success">Edit the product</a>
                <a href="/product_destroy/{{ $prod->id }}" type=" button" class="btn btn-danger">Remove Product</a>
            @endif
            @if ($data_arr[1] == 'admin')
                <a href="/product_edit/{{ $prod->id }}" type=" button" class="btn btn-primary">Edit product</a>
                <a href="/product_destroy/{{ $prod->id }}" type=" button" class="btn btn-danger">Remove Product</a>
            @endif

        @endforeach
    @else
        NO PRODUCTS FOUND
    @endif
@endsection
@push('JsScript')
    <script>
        function post() {
            var x = {
                id: event.target.id
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/cart/store',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(x),
                success: function(data) {
                    console.log('Posted');
                }

            });
        }

    </script>
@endpush
