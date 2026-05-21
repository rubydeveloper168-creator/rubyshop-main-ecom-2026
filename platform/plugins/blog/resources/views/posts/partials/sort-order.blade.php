@if (Auth::user()->hasPermission('posts.edit'))
    <span
        class="post-order-handle text-secondary me-2"
        style="cursor: move;"
        title="{{ trans('core/base::forms.sort_order') }}"
    >
        <x-core::icon name="ti ti-arrows-sort" />
    </span>
    <a
        class="editable"
        data-type="text"
        data-pk="{{ $item->id }}"
        data-url="{{ route('posts.update-order-by') }}"
        data-value="{{ $item->order ?? 0 }}"
        data-title="{{ trans('core/base::forms.sort_order') }}"
        href="#"
    >{{ $item->order ?? 0 }}</a>
@else
    {{ $item->order ?? 0 }}
@endif
