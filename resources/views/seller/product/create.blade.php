@extends('layouts.app')
@section('content')

    <form action="{{ route('product.store') }}" method='post' enctype="multipart/form-data">
        @csrf
        <div
            class="uk-width-1-1 uk-height-1-1 uk-padding-large uk-padding-remove-horizontal uk-flex uk-flex-around uk-flex-middle cproduct">
            <div class="uk-card uk-card-default uk-card-body uk-width-2-3@m">
                <h1 class="uk-heading-divider uk-text-center uk-text-bold cproduct-head">Create a Product</h1>
                <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                    <label class="uk-width-1-5@m uk-text-bold" for="name">Name :</label>
                    <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                        <i class="uk-form-icon ri-pencil-fill"></i>
                        <input class="uk-input" type="text" id="name" name="name">
                    </div>
                </div>
                <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                    <label class="uk-width-1-5@m uk-text-bold" for="type">Category :</label>
                    <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                        <i class="uk-form-icon ri-pencil-fill"></i>
                        {{-- <input class="uk-input" type="text" id="type" name="type"> --}}
                        <select name="type" id="type" class="uk-input uk-select">
                            @foreach (App\Models\Product::$categories as $index => $category)
                                <option value="{{ $index }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-flex uk-flex-between uk-flex-middle uk-flex-wrap">
                    <div class="uk-padding-small">
                        <label class="uk-text-bold uk-margin-right" for="unit">Unit :</label>
                        <div class="uk-inline">
                            <i class="uk-form-icon ri-pencil-fill"></i>
                            <select class="uk-input uk-select" name="unit" id="unit">
                                <optgroup label="Mostly Used">
                                    @foreach (array_slice(App\Models\Product::$units, 0, 4) as $abbrev => $unit)
                                        <option value="{{ $abbrev }}">{{ $unit }}</option>
                                    @endforeach
                                </optgroup>
                                @foreach (array_slice(App\Models\Product::$units, 4) as $abbrev => $unit)
                                    <option value="{{ $abbrev }}">{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="uk-padding-small">
                        <label class="uk-text-bold uk-margin-right" for="quantity">Quantity :</label>
                        <div class="uk-inline">
                            <i class="uk-form-icon ri-pencil-fill"></i>
                            <input class="uk-input" type="number" id="quantity" name="quantity" value="1" min="1">
                        </div>
                    </div>
                </div>
                <div class="uk-flex uk-flex-between uk-flex-middle uk-flex-wrap">
                    <div class="uk-padding-small">
                        <label class="uk-text-bold uk-margin-right" for="price">Price :</label>
                        <div class="uk-inline">
                            <span class="uk-form-icon">₹</span>
                            <input class="uk-input" type="number" placeholder="" id="price" name="price" value="0" min="0">
                        </div>
                    </div>
                    <div class="uk-padding-small">
                        <label class="uk-text-bold uk-margin-right" for="discount">Discount :</label>
                        <div class="uk-inline">
                            <div class="uk-form-icon uk-form-icon-flip">
                                <span class="ri-percent-fill"></span>
                            </div>
                            <input class="uk-input" class="discount" name="discount" type="number" min="0.05" max="0.75"
                                step="0.01" />
                        </div>
                        <div>
                            <input class="uk-range" type="range" min="0.05" max="0.75" step="0.01" id="discount-range"
                                name="discount-range">

                        </div>
                    </div>
                </div>

                <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                    <label class="uk-width-1-5@m uk-text-bold" for="imageInput">Cover :</label>
                    <input name="cover[]" type="file" id="cover" multiple>
                </div>


                <div class="js-upload uk-placeholder uk-text-center" hidden>
                    <span uk-icon="icon: cloud-upload"></span>
                    <span class="uk-text-middle">Attach binaries by dropping them here or</span>
                    <div uk-form-custom>
                        <input type="file" multiple>
                        <span class="uk-link">selecting one</span>
                    </div>
                </div>

                <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

                <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                    <label class="uk-width-1-5@m uk-text-bold" for="name">Description :</label>
                    <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                        <textarea class="uk-textarea" rows="5" id="desc" name="desc"></textarea>
                    </div>
                </div>
                <div class="uk-flex uk-flex-around">
                    <button type="submit" class="uk-button cproduct-btn">Submit</button>
                </div>

            </div>
        </div>
    </form>

    </html>
@endsection

@section('scripts')
    <script>
        $('input[name="discount"]').val(($('#discount-range').val()));
        $('input[name="discount"]').on('change', function(event) {
            $('#discount-range').val(event.target.value);
        })
        $('#discount-range').on('change', function(event) {
            $('input[name="discount"]').val((event.target.value));
        });

        CKEDITOR.replace('desc');

        var bar = document.getElementById('js-progressbar');

        UIkit.upload('.js-upload', {

            url: '',
            multiple: true,

            beforeSend: function() {
                console.log('beforeSend', arguments);
            },
            beforeAll: function() {
                console.log('beforeAll', arguments);
            },
            load: function() {
                console.log('load', arguments);
            },
            error: function() {
                console.log('error', arguments);
            },
            complete: function() {
                console.log('complete', arguments);
            },

            loadStart: function(e) {
                console.log('loadStart', arguments);

                bar.removeAttribute('hidden');
                bar.max = e.total;
                bar.value = e.loaded;
            },

            progress: function(e) {
                console.log('progress', arguments);

                bar.max = e.total;
                bar.value = e.loaded;
            },

            loadEnd: function(e) {
                console.log('loadEnd', arguments);

                bar.max = e.total;
                bar.value = e.loaded;
            },

            completeAll: function() {
                console.log('completeAll', arguments);

                setTimeout(function() {
                    bar.setAttribute('hidden', 'hidden');
                }, 1000);

                alert('Upload Completed');
            }


        });
    </script>
@endsection
