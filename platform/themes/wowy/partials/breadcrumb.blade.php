<div class="page-header breadcrumb-wrap">
    <div class="container">
        @php
            $crumbs = Theme::breadcrumb()->getCrumbs();

            if (request()->is('products/*')) {
                $crumbs = array_values(array_slice($crumbs, -2));
            }
        @endphp
        <div class="breadcrumb">
            @foreach ($crumbs as $i => $crumb)
                @if ($i != (count($crumbs) - 1))
                    <div class="breadcrumb-item d-inline-block">
                        <a href="{{ $crumb['url'] }}" title="{{ $crumb['label'] }}">
                            {!! BaseHelper::clean($crumb['label']) !!}
                        </a>
                    </div>
                    <span></span>
                @else
                    <div class="breadcrumb-item d-inline-block active">
                        <i>
                            {!! BaseHelper::clean($crumb['label']) !!}
                        </i>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
