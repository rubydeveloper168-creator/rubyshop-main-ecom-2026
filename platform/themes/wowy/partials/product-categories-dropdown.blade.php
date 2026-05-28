@php
    $groupedCategories = $categories->groupBy('parent_id');
    $topCategories = $groupedCategories->get(0, collect());

    $displayName = function(string $name): string {
        if (str_contains($name, '|')) {
            $parts = array_map('trim', explode('|', $name));
            return end($parts);
        }
        return $name;
    };
@endphp

@foreach ($topCategories as $category)
    @if ((!$more && $loop->index < 10) || ($more && $loop->index >= 10))
        @php
            $children = $groupedCategories->get($category->id, collect());
            $hasChildren = $children->isNotEmpty();
        @endphp

        <li class="{{ $hasChildren ? 'has-children' : '' }}">
            <a href="{{ route('public.single', $category->url) }}">
                @if ($iconImage = $category->icon_image)
                    <img src="{{ RvMedia::getImageUrl($iconImage) }}"
                         alt="{{ $displayName($category->name) }}"
                         width="20" height="20" loading="lazy">
                @elseif ($icon = $category->icon)
                    {!! BaseHelper::renderIcon($icon) !!}
                @endif
                {{ $displayName($category->name) }}
            </a>

            @if ($hasChildren)
                <div class="dropdown-menu">
                    <ul>
                        @foreach ($children as $child)
                            @php
                                $grandChildren = $groupedCategories->get($child->id, collect());
                                $hasGrandChildren = $grandChildren->isNotEmpty();
                            @endphp
                            <li class="{{ $hasGrandChildren ? 'has-children' : '' }}">
                                <a class="dropdown-item nav-link nav_item"
                                   href="{{ route('public.single', $child->url) }}">
                                    {{ $displayName($child->name) }}
                                </a>

                                @if ($hasGrandChildren)
                                    <div class="dropdown-menu">
                                        <ul>
                                            @foreach ($grandChildren as $item)
                                                <li>
                                                    <a class="dropdown-item nav-link nav_item"
                                                       href="{{ route('public.single', $item->url) }}">
                                                        {{ $displayName($item->name) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </li>
    @endif
@endforeach
