@extends('layouts.app')

@php
    $productImages = json_decode($product->images ?? '[]', true);
    $productFirstImage = is_array($productImages) ? ($productImages[0] ?? null) : null;
    $productImageUrl = $productFirstImage ? asset($productFirstImage) : asset('images/no-image.jpg');
    $productPrice = $product->sale_price ?: $product->price;
    $productDescription = trim(strip_tags($product->description ?: $product->name));
@endphp

@section('seo_title', ($product->name ?? 'สินค้า') . ' | RUBYSHOP')
@section('seo_description', \Illuminate\Support\Str::limit($productDescription, 160))
@section('seo_image', $productImageUrl)

@section('content')
<article class="container">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => [$productImageUrl],
            'description' => $productDescription,
            'sku' => $product->sku ?: null,
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'THB',
                'price' => (float) $productPrice,
                'availability' => $product->stock_status === 'in_stock'
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'url' => request()->url(),
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row mt-4">
        <div class="col-md-6">
            <img src="{{ $productImageUrl }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            
            <div class="mb-3">
                @if ($product->sale_price)
                    <span class="text-muted text-decoration-line-through fs-4">${{ number_format($product->price, 2) }}</span>
                    <span class="text-danger fs-3">${{ number_format($product->sale_price, 2) }}</span>
                @else
                    <span class="fs-3">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            
            <div class="mb-3">
                @if ($product->stock_status === 'in_stock')
                    <span class="badge bg-success">In Stock</span>
                @else
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
                
                @if ($product->sku)
                    <span class="ms-2">SKU: {{ $product->sku }}</span>
                @endif
            </div>
            
            <div class="mb-4">
                <p>{{ $product->description }}</p>
            </div>
            
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="button">Add to Cart</button>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <h2 id="product-details">{{ __('Product Details') }}</h2>
            <hr>
            <div>
                {!! $product->content !!}
            </div>
        </div>
    </div>
</article>
@endsection
