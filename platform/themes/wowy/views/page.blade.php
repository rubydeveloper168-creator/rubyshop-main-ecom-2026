@php
    $page->loadMissing('metadata');

    Theme::set('page', $page);

    $isContactPage = request()->is('contact*')
        || \Illuminate\Support\Str::contains($page->content, ['id="contact"', "id='contact'"])
        || \Illuminate\Support\Str::contains(strtolower((string) $page->name), 'contact');
@endphp

<style>
    @if ($isContactPage)
    #main-section > .container {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #main-section > .container > .mt-60.mb-60 {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
    @endif

    .legal-page-content,
    .legal-page-content * {
        font-family: inherit;
    }

    .legal-page-content {
        max-width: 960px;
        margin: 0 auto;
        color: #1f2937;
        line-height: 1.8;
        font-size: 16px;
        word-break: break-word;
    }

    .legal-page-content h1,
    .legal-page-content h2,
    .legal-page-content h3,
    .legal-page-content h4,
    .legal-page-content h5,
    .legal-page-content h6 {
        line-height: 1.35;
        font-weight: 700;
        margin-top: 1.25em;
        margin-bottom: 0.6em;
    }

    .legal-page-content p,
    .legal-page-content li,
    .legal-page-content div,
    .legal-page-content span {
        font-size: inherit !important;
        line-height: inherit !important;
    }

    .legal-page-content p,
    .legal-page-content ul,
    .legal-page-content ol {
        margin-bottom: 1rem;
    }

    .legal-page-content ul,
    .legal-page-content ol {
        padding-left: 1.25rem;
    }
</style>

@if ($page->template === 'homepage')
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
@elseif ($page->template === 'default')
    @if ($isContactPage)
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
    @else
        <section class="mt-60 mb-60">
            {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content legal-page-content'])->toHtml(), $page) !!}
        </section>
    @endif
@else
    @if ($isContactPage)
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
    @else
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content legal-page-content'])->toHtml(), $page) !!}
    @endif
@endif
