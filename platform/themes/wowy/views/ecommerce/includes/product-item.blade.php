@if ($product && $product instanceof \Botble\Ecommerce\Models\Product)
    <div class="product-cart-wrap mb-30 product-item-wrapper">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ $product->url }}">
                    <img class="default-img" src="{{ RvMedia::getImageUrl($product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                    <img class="hover-img" src="{{ RvMedia::getImageUrl($product->images[1] ?? $product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                </a>
            </div>
            
            <div class="product-badges product-badges-position product-badges-mrg">
                @if ($product->isOutOfStock())
                    <span style="background-color: #000; font-size: 11px;">{{ __('Out Of Stock') }}</span>
                @else
                    @if ($product->productLabels->count())
                        @foreach ($product->productLabels as $label)
                            <span @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                        @endforeach
                    @elseif ($product->front_sale_price !== $product->price && $percentSale = get_sale_percentage($product->price, $product->front_sale_price))
                        <span class="hot">{{ $percentSale }}</span>
                    @endif
                @endif
            </div>
        </div>
        <div class="product-content-wrap">
            <div class="product-category">
                @php $category = $product->categories->sortByDesc('id')->first(); @endphp
                @if ($category)
                    <a href="{{ $category->url }}">{{ $category->name }}</a>
                @else
                    &nbsp;
                @endif
            </div>
            <h2 class="text-truncate product-title mb-5">
                <a href="{{ $product->url }}" title="{{ $product->name }}">{{ $product->name }}</a>
            </h2>
            @if (EcommerceHelper::isReviewEnabled())
                <div class="rating_wrap">
                    <div class="rating">
                        <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                    </div>
                    <span class="rating_num">({{ $product->reviews_count }})</span>
                </div>
            @endif
            {!! apply_filters('ecommerce_before_product_price_in_listing', null, $product) !!}
            <div class="product-price">
                <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                @if ($product->front_sale_price !== $product->price)
                    <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
                @endif
            </div>
            {!! apply_filters('ecommerce_after_product_price_in_listing', null, $product) !!}
            @if (EcommerceHelper::isCartEnabled())
                <div class="product-action-1 show" @if (!EcommerceHelper::isReviewEnabled()) style="bottom: 10px;" @endif>
                    <a aria-label="{{ __('Add To Cart') }}" class="action-btn hover-up add-to-cart-button" data-id="{{ $product->id }}" data-url="{{ route('public.cart.add-to-cart') }}" href="#">
                        <i class="far fa-shopping-bag"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

   

    

<style>
    .product-item-wrapper .product-img-action-wrap:hover .product-action-1:not(.show) {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }

    .product-item-wrapper.product-cart-wrap,
    .product-item-wrapper .product-cart-wrap {
        height: 100%;
    }

    .product-item-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-item-wrapper .product-content-wrap {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
    }

    .product-item-wrapper .product-category {
        min-height: 20px;
        margin-bottom: 4px;
    }

    .product-item-wrapper .product-title {
        min-height: 44px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-item-wrapper .rating_wrap {
        min-height: 22px;
    }

    .product-item-wrapper .product-price {
        min-height: 34px;
    }

    @media (max-width: 767px) {
        /* Force 2-column layout */
        .products-listing .row,
        .shop-product-fillter .row,
        .row.product-grid-4,
        .row.product-grid-3,
        .row.product-grid-5 {
            display: flex;
            flex-wrap: wrap;
            margin-left: -7px;
            margin-right: -7px;
        }
        
        /* Target all product containers */
        .products-listing .row > div,
        .shop-product-fillter .row > div,
        .row.product-grid-4 > div,
        .row.product-grid-3 > div,
        .row.product-grid-5 > div,
        .col-lg-3.col-md-4.col-12.col-sm-6,
        .col-lg-4.col-md-4.col-12.col-sm-6,
        .col-xl-3.col-lg-4.col-md-6.col-sm-6.col-12 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            padding-left: 7px !important;
            padding-right: 7px !important;
            margin-bottom: 12px !important;
        }
        
        /* Adjust image size */
        .product-img {
            height: 120px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .product-img img {
            max-height: 120px !important;
            object-fit: contain !important;
            width: auto !important;
            margin: 0 auto !important;
        }
        
        /* Hide hover image on mobile to save resources */
        .product-img .hover-img {
            display: none !important;
        }
        
        /* Fix the layering issue - more aggressive approach */
        .product-content-wrap {
            position: relative !important;
            padding: 10px 5px 5px 5px !important;
            margin-top: 20px !important;
            min-height: 168px !important;
        }
        
        /* Move rating below the title */
        .rating_wrap {
            position: relative !important;
            margin-top: 40px !important; /* Make space for title above */
            margin-bottom: 5px !important;
        }
        
        /* Position title above rating */
        .product-title,
        .product-cart-wrap h2,
        .product-content-wrap h2 {
            position: absolute !important;
            top: 30px !important; /* Position after category */
            left: 5px !important;
            right: 5px !important;
            font-size: 0.85rem !important;
            height: 40px !important;
            overflow: hidden !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            white-space: normal !important;
            background-color: #fff !important; /* Solid background */
            z-index: 5 !important; /* Very high z-index */
            margin: 0 !important;
            padding: 0 !important;
            min-height: 40px !important;
        }
        
        /* Category positioning */
        .product-category {
            font-size: 0.7rem !important;
            margin-bottom: 3px !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* Price positioning - after the rating */
        .product-price {
            font-size: 0.85rem !important;
            margin-bottom: 5px !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        .product-price .old-price {
            font-size: 0.75rem !important;
        }
        
        /* Make action buttons smaller and more compact */
        .product-action-1 .action-btn {
            width: 30px !important;
            height: 30px !important;
            line-height: 30px !important;
            font-size: 12px !important;
        }
        
        /* Adjust product badges */
        .product-badges span {
            font-size: 9px !important;
            padding: 3px 6px !important;
        }
        
        /* Adjust rating size */
        .rating {
            transform: scale(0.8) !important;
            transform-origin: left !important;
        }
        
        .rating_num {
            font-size: 0.7rem !important;
        }
        
        /* Adjust add to cart button */
        .add-to-cart-button {
            width: 30px !important;
            height: 30px !important;
            line-height: 30px !important;
            font-size: 12px !important;
        }
        
        /* Reduce spacing between products */
        .product-cart-wrap {
            margin-bottom: 12px !important;
            min-height: 320px !important;
        }
        
        /* Increase overall height to accommodate the repositioned elements */
        .product-content-wrap {
            min-height: 120px !important;
        }
        .text-truncate {
      
            margin-bottom: 100px !important;
            margin-top: 10px !important;
        }
    }
</style>
<style>
    @media (max-width: 767px) {
        /* Other mobile styles remain the same */
        
        /* Modified product title styling for single line with ellipsis */
        .product-title, 
        .product-cart-wrap h2,
        .product-content-wrap h2,
        .text-truncate {
            font-size: 0.85rem !important;
            margin-bottom: 5px !important;
            height: 20px !important; /* Reduced height for single line */
            overflow: hidden !important;
            text-overflow: ellipsis !important; /* Add ellipsis */
            white-space: nowrap !important; /* Force single line */
            width: 100% !important;
        }
        
        /* Make sure the title links also truncate */
        .product-title a, 
        .product-cart-wrap h2 a,
        .product-content-wrap h2 a {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            width: 100% !important;
            display: inline-block !important;
        }
    }
</style>





@endif
