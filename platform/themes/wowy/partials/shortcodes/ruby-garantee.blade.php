@php
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $backgroundColor = Arr::get($attributes, 'background_color', '#ed1d24');
    $textColor = Arr::get($attributes, 'text_color', '#000000');
    $title = Arr::get($attributes, 'title');
    $subtitle = Arr::get($attributes, 'subtitle');

    // Auto-upgrade old copy to the new brand copy.
    if (trim((string) $title) === 'Guaranteed Tough®') {
        $title = 'Built for Pros®';
    }

    if (trim((string) $subtitle) === 'เพื่อช่างมืออาชีพ งานจบไว มั่นใจคุณภาพ') {
        $subtitle = 'เพื่อช่างมืออาชีพ ทำงานไว จบงานเนี๊ยบ มั่นใจทุกไซต์งาน';
    }
@endphp

@if ($title || $subtitle)
    <section class="ruby-garantee-banner py-4 md:py-6 text-center flex flex-col justify-center" style="background-color: {{ $backgroundColor }}; color: {{ $textColor }};">
        @if ($title)
            <h4 class="text-2xl md:text-3xl font-bold uppercase mb-1 md:mb-2 leading-tight" style="color: {{ $textColor }};">{!! BaseHelper::clean($title) !!}</h4>
        @endif
        @if ($subtitle)
            <p class="text-sm md:text-base uppercase leading-snug" style="color: {{ $textColor }};">{!! BaseHelper::clean($subtitle) !!}</p>
        @endif
    </section>
    <style>
        @media (max-width: 767px) {
            .ruby-garantee-banner {
                min-height: 96px;
                padding-top: 14px !important;
                padding-bottom: 14px !important;
            }
        }
    </style>
@endif
