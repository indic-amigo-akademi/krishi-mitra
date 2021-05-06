@extends('layouts.app')
@section('content')
    <h1>Update Product</h1>
    <form action="/product_update/{{ $prod->id }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="type">Product Type</label>
            <input type="text" class="form-control" id="type" name="type" value={{ $prod->type }}>
        </div>
        <div class="form-group">
            <label for="desc">Product Description</label>
            <input type="text" class="form-control" id="desc" value={{ $prod->desc }} name="desc">
        </div>
        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="text" class="form-control" id="price" value={{ $prod->price }} name="price">
        </div>
        <div class="form-group">
            <label for="discount">Product Discount</label>
            <input type="text" class="form-control" id="discount" value={{ $prod->discount }} name="discount">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
