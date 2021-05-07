@extends('layouts.app');
@section('content')
    <form action="/product_store" method='Post' enctype="multipart/form-data">
        @csrf
        <h1>Create Product</h1>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type">
        </div>
        <div class="form-group">
            <label for="desc">Description:</label>
            <input type="text" class="form-control" id="desc" name="desc">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>
        <div class="form-group">
            <label for="imageInput">Cover</label>
            <input name="input_img" type="file" id="input_img">
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="unit">Unit:</label>
            <input type="string" class="form-control" id="unit" name="unit">
        </div>
        <div class="form-group">
            <label for="qty">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity">
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
@endsection
