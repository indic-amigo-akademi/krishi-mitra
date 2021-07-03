@extends('layouts.app')
@section('content')
    <form action="{{ route('product.update', $product->id) }}" method="POST">
        @csrf
        <div
            class="uk-width-1-1 uk-height-1-1 uk-padding-large uk-padding-remove-horizontal uk-flex uk-flex-around uk-flex-middle cproduct">
            <div class="uk-card uk-card-default uk-card-body uk-width-2-3@m">
                <h1 class="uk-heading-divider uk-text-center uk-text-bold cproduct-head">Update Your Product</h1>
                <div class="uk-padding-small uk-flex uk-flex-middle">
                    <label class="uk-width-1-5 uk-text-bold" for="type">Category :</label>
                    <div class="uk-inline uk-width-4-5">
                        <a class="uk-form-icon ri-pencil-fill" href="#"></a>
                        <select name="type" id="type" class="uk-input uk-select">
                            @foreach (App\Product::$categories as $index => $category)
                                <option value="{{ $index }}" @if ($product->category == $index) selected @endif>
                                    {{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-padding-small uk-flex uk-flex-middle">
                    <label class="uk-width-1-5 uk-text-bold" for="name">Name :</label>
                    <div class="uk-inline uk-width-4-5">
                        <a class="uk-form-icon ri-pencil-fill" href="#"></a>
                        <input class="uk-input" type="text" id="name" name="name" value={{ $product->name }}>
                    </div>
                </div>
                <div class="uk-padding-small uk-flex uk-flex-between uk-flex-middle">
                    <div>
                        <label class="uk-text-bold uk-margin-right" for="unit">Unit :</label>
                        <div class="uk-inline">
                            <a class="uk-form-icon ri-pencil-fill" href="#"></a>
                            <select class="uk-input uk-select" name="unit" id="unit">
                                <optgroup label="Mostly Used">
                                    @foreach (array_slice(App\Product::$units, 0, 4) as $abbrev => $unit)
                                        <option value="{{ $abbrev }}" @if ($product->unit == $abbrev) selected @endif>
                                            {{ $unit }}</option>
                                    @endforeach
                                </optgroup>
                                @foreach (array_slice(App\Product::$units, 4) as $abbrev => $unit)
                                    <option value="{{ $abbrev }}" @if ($product->unit == $abbrev) selected @endif>
                                        {{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="uk-text-bold uk-margin-right" for="qty">Quantity :</label>
                        <div class="uk-inline">
                            <a class="uk-form-icon ri-pencil-fill" href="#"></a>
                            <input class="uk-input" type="number" id="quantity" name="quantity" min="1"
                                value={{ $product->quantity }}>
                        </div>
                    </div>
                </div>
                <div class="uk-padding-small uk-flex uk-flex-between uk-flex-middle">
                    <div>
                        <label class="uk-text-bold uk-margin-right" for="price">Price :</label>
                        <div class="uk-inline">
                            <span class="uk-form-icon">₹</span>
                            <input class="uk-input" type="number" placeholder="₹" id="price" name="price" min="0"
                                value={{ $product->price }}>
                        </div>
                    </div>
                    <div>
                        <label class="uk-text-bold uk-margin-right" for="disc">Discount :</label>
                        <div class="uk-inline">
                            <a class="uk-form-icon uk-form-icon-flip ri-percent-fill" href="#"></a>
                            <input class="uk-input" type="number" id="discount" name="discount" min="0.05" max="0.75"
                                step="0.01" value={{ $product->discount }}>
                        </div>
                    </div>
                </div>
                <div class="uk-padding-small uk-flex uk-flex-middle">
                    <label class="uk-width-1-5 uk-text-bold" for="name">Description :</label>
                    <div class="uk-inline uk-width-4-5">
                        <textarea class="uk-textarea" rows="5" id="desc" name="desc">{{ $product->desc }}</textarea>
                    </div>
                </div>
                <div class="uk-flex uk-flex-around">
                    <button type="submit" class="uk-button cproduct-btn">Submit</button>
                </div>

            </div>
        </div>

        {{-- <div class="form-group">
            <label for="type">Product Type</label>
            <input type="text" class="form-control" id="type" name="type" value={{ $prod->type }}>
        </div>
        <div class="form-group">
            <label for="desc">Product Description</label>
            <textarea class="form-control" id="desc" name="desc">{{ $prod->desc }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="text" class="form-control" id="price" value={{ $prod->price }} name="price">
        </div>
        <div class="form-group">
            <label for="discount">Product Discount</label>
            <input type="text" class="form-control" id="discount" value={{ $prod->discount }} name="discount">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button> --}}

    </form>
@endsection
@section('scripts')
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('desc');
    </script>
@endsection
