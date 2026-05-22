@php
    $showPageHeader = false;
@endphp

<div class="single-header mb-80 mx-4 sm:mx-0">
    <h1 class="font-xxl text-brand">{{ SeoHelper::getTitle() }}</h1>
</div>

@include(Theme::getThemeNamespace() . '::views.templates.posts', compact('posts', 'showPageHeader'))
