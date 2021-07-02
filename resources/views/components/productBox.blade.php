<div class="uk-card uk-card-default uk-width-1-2 uk-width-1-3@s uk-width-1-4@l uk-flex-left product-box">
    <div class="uk-card-media-top">
        <a href="{{ route('product.view', $product->slug) }}" class="uk-flex uk-flex-center">
            <img src="{{ isset($product->coverPhotos) ? asset('uploads/products/' . $product->coverPhotos[0]->name) : asset('images/icons/no_preview.png') }}"
                uk-img />
        </a>
    </div>
    <div class="uk-padding-remove">
        <div class="uk-card-body uk-padding-small">
            <div class="uk-margin-small-bottom">
                <a href="{{ route('product.view', $product->slug) }}">
                    <span style="font-family: cursive">{{ $product->name }}</span>
                </a>
                |
                <a href="{{ route('explore') . '?c=' . $product->type }}">
                    <span class="uk-text-bold">{{ $product->category }}</span>
                </a>
            </div>
            <div class="uk-margin-small-bottom uk-text-bold uk-text-small">
                <span class="sprod-color">
                    ₹ {{ $product->price }}
                </span>
                per {{ $product->unit }}
            </div>
        </div>
    </div>
    <div class="uk-flex uk-flex-between uk-card-footer uk-padding-small">
        <a href="#" onclick="addToCart('{{ $product->id }}')" class="uk-text-primary">
            <i class="ri-shopping-bag-line"></i>
            <span class="icon-text">Add to Cart</span>
        </a>
        <a href="#" onclick="buyNow('{{ $product->id }}')" class="uk-text-primary">
            <i class="ri-shopping-cart-line"></i>
            <span class="icon-text">Buy Now</span>
        </a>
    </div>
</div>
