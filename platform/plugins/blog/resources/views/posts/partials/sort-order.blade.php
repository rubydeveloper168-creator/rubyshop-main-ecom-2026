@if (Auth::user()->hasPermission('posts.edit'))
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
