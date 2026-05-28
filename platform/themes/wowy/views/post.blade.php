@php
    $layout = MetaBox::getMetaData($post, 'layout', true);
    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'blog-right-sidebar';
    Theme::layout($layout);
@endphp

<style>
    .single-page .ck-content {
        line-height: 1.8;
        font-size: 16px;
        word-break: break-word;
    }

    .single-page .ck-content > * + * {
        margin-top: 1rem;
    }

    .single-page .ck-content h1,
    .single-page .ck-content h2,
    .single-page .ck-content h3,
    .single-page .ck-content h4,
    .single-page .ck-content h5,
    .single-page .ck-content h6 {
        line-height: 1.3;
        margin: 1.5rem 0 1rem;
    }

    .single-page .ck-content h1 {
        font-size: 2rem;
    }

    .single-page .ck-content h2 {
        font-size: 1.75rem;
    }

    .single-page .ck-content h3 {
        font-size: 1.5rem;
    }

    .single-page .ck-content p,
    .single-page .ck-content li {
        font-size: 1rem;
        line-height: 1.85;
    }

    .single-page .ck-content ul,
    .single-page .ck-content ol {
        padding-left: 1.4rem;
        margin: 0 0 1rem;
    }

    .single-page .ck-content li {
        margin-bottom: 0.5rem;
    }
</style>




<div class="single-page mx-4 sm:mx-0">
    <div class="single-header style-2">
        <h1 class="mb-30">{{ $post->name }}</h1>
        <div class="single-header-meta">
            <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                <span class="post-on has-dot ms-2">{{ $post->created_at->translatedFormat('M d, Y') }}</span>
                <span class="time-reading has-dot ms-2">{{ __(':count mins read', ['count' => get_time_to_read($post)]) }}</span>
                <span class="hit-count has-dot ms-2">{{ __(':count Views', ['count' => number_format($post->views)]) }}</span>
            </div>
        </div>
    </div>
    <div class="single-content">
        <div class="ck-content">{!! BaseHelper::clean($post->content) !!}</div>

        <br>
        {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $post) !!}
    </div>
    <div class="entry-bottom mt-50 mb-30 wow fadeIn  animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="tags w-50 w-sm-100">
            @if (!$post->tags->isEmpty())
                @foreach ($post->tags as $tag)
                    <a href="{{ $tag->url }}" rel="tag" class="hover-up btn btn-sm btn-rounded mr-10 mb-10">{{ $tag->name }}</a>
                @endforeach
            @endif
        </div>
    </div>
    <div class="social-icons social-icons-colored-hover mb-30">
        <ul class="text-grey-5 d-inline-block">
            <li><strong class="mr-10">{{ __('Share this') }}:</strong></li>
            <li class="social-facebook">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->url) }}" target="_blank">
                    <i class="fab fa-facebook-f"></i><span class="visually-hidden">Share on Facebook</span>
                </a>
            </li>
            <li class="social-twitter">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ strip_tags($post->description) }}" target="_blank">
                    <i class="fab fa-twitter"></i><span class="visually-hidden">Share on X</span>
                </a>
            </li>
            <li class="social-linkedin">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($post->url) }}&summary={{ rawurldecode(strip_tags($post->description)) }}" target="_blank">
                    <i class="fab fa-linkedin"></i><span class="visually-hidden">Share on LinkedIn</span>
                </a>
            </li>
        </ul>
    </div>
</div>

@php $relatedPosts = get_related_posts($post->id, 2); @endphp
@if ($relatedPosts->count())
    <div class="loop-grid pr-30">
        <h4 class="mb-20">{{ __('Related Articles') }}</h4>
        <div class="row">
            @foreach ($relatedPosts as $relatedItem)
                <div class="col-lg-6 col-md-6">
                    <article class="wow fadeIn animated hover-up mb-30">
                        <div class="post-thumb img-hover-scale">
                            <a href="{{ $relatedItem->url }}">
                                <img src="{{ RvMedia::getImageUrl($relatedItem->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $relatedItem->name }}">
                            </a>
                            @if ($relatedItem->first_category->name)
                                <div class="entry-meta">
                                    <a class="entry-meta meta-2" href="{{ $relatedItem->first_category->url }}">{{ $relatedItem->first_category->name }}</a>
                                </div>
                            @endif
                        </div>
                        <div class="entry-content-2">
                            <h3 class="post-title mb-15">
                                <a href="{{ $relatedItem->url }}">{{ $relatedItem->name }}</a></h3>
                            <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span class="post-on has-dot"> <i class="far fa-clock"></i> {{ $relatedItem->created_at->translatedFormat('M d, Y') }}</span>
                                </div>
                                <a href="{{ $relatedItem->url }}" class="text-brand">{{ __('Read more') }} <i class="fa fa-arrow-right fw-300 text-brand ml-5"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
@endif
