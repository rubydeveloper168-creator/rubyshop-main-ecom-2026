@php
    $desktopVideo = asset('storage/ads/vdo.mp4');
    $desktopPoster = asset('storage/ads01/30l/m30l-hero.jpg');
    $mobileImage = asset('storage/ads01/30l/m30l-hero.jpg');
@endphp

{!! do_shortcode('[hero-video-mobile-image-ruby desktop_video="' . $desktopVideo . '" desktop_poster="' . $desktopPoster . '" mobile_image="' . $mobileImage . '" title="เครื่องมือช่างเพื่อมืออาชีพ" subtitle="งานจบไว มาตรฐานสูง พร้อมบริการจาก RUBYSHOP" button_text="ดูสินค้า" button_link="/product-categories/airless-sprayer"][/hero-video-mobile-image-ruby]') !!}
