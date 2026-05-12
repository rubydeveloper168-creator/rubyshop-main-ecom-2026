@php
    use Botble\Base\Facades\Form;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $defaultCards = [
        [
            'image' => null,
            'title' => 'Control Series',
            'subtitle' => 'Stain Sprayers',
            'link' => '/product-categories/control-series',
        ],
        [
            'image' => null,
            'title' => 'FLEXiO',
            'subtitle' => 'Paint & Stain Sprayers',
            'link' => '/product-categories/flexio',
        ],
        [
            'image' => null,
            'title' => 'Control Pro',
            'subtitle' => '',
            'link' => '/product-categories/control-pro',
        ],
        [
            'image' => null,
            'title' => 'Earlex',
            'subtitle' => '',
            'link' => '/product-categories/earlex',
        ],
        [
            'image' => null,
            'title' => 'FURNO',
            'subtitle' => '',
            'link' => '/product-categories/furno',
        ],
        [
            'image' => null,
            'title' => 'Steamer',
            'subtitle' => '',
            'link' => '/product-categories/steamer',
        ],
    ];

    $cardsValue = $content ?: Arr::get($attributes, 'cards');

    if (is_string($cardsValue)) {
        $cardsValue = json_decode($cardsValue, true) ?: [];
    }

    if (! is_array($cardsValue) || empty($cardsValue)) {
        $cardsValue = $defaultCards;
    }

    if (! Arr::isList($cardsValue)) {
        $cardsValue = array_values($cardsValue);
    }

    $sectionId = 'shop-by-category-admin-' . uniqid();
@endphp

<div id="{{ $sectionId }}" class="shop-by-category-cards-admin">
    <div class="mb-3">
        <label class="form-label">{{ __('Section title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($attributes, 'title', __('Shop By Category')) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('Button text') }}</label>
        <input type="text" name="button_text" value="{{ Arr::get($attributes, 'button_text', __('View All Products')) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('Button URL') }}</label>
        <input type="text" name="button_link" value="{{ Arr::get($attributes, 'button_link', '/allproducts') }}" class="form-control" placeholder="/allproducts">
    </div>

    <div class="mb-3">
        <label class="form-label d-flex align-items-center justify-content-between">
            <span>{{ __('Cards') }}</span>
            <button type="button" class="btn btn-sm btn-primary" data-card-add>
                {{ __('Add card') }}
            </button>
        </label>

        <textarea name="cards" class="d-none" data-shortcode-attribute="content" data-cards-json>{{ json_encode($cardsValue, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</textarea>

        <div class="card-list" data-card-list></div>
    </div>

    <template data-card-template>
        <div class="card border mb-3" data-card-item>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong>{{ __('Card') }} <span data-card-number></span></strong>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-card-remove>
                        {{ __('Remove') }}
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Image') }}</label>
                    <div data-card-field="image" data-card-image-wrapper>
                        {!! Form::mediaImage('__IMAGE_NAME__', null, [
                            'disabled' => true,
                            'allow_thumb' => false,
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Title') }}</label>
                    <input type="text" class="form-control" data-card-field="title" value="" placeholder="{{ __('Title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Subtitle') }}</label>
                    <input type="text" class="form-control" data-card-field="subtitle" value="" placeholder="{{ __('Subtitle') }}">
                </div>

                <div class="mb-0">
                    <label class="form-label">{{ __('Link') }}</label>
                    <input type="text" class="form-control" data-card-field="link" value="" placeholder="/product-categories/example">
                </div>
            </div>
        </div>
    </template>
</div>

@once
    <script>
        (function () {
            const root = document.getElementById(@json($sectionId));

            if (!root) {
                return;
            }

            const list = root.querySelector('[data-card-list]');
            const template = root.querySelector('[data-card-template]');
            const jsonField = root.querySelector('[data-cards-json]');
            const addButton = root.querySelector('[data-card-add]');

            const defaults = @json($cardsValue);

            const sanitize = (value) => (value ?? '').toString();

            const readRow = (row) => {
                const imageField = row.querySelector('[data-card-field="image"] input') || row.querySelector('[data-card-field="image"]');

                return {
                    image: sanitize(imageField && imageField.value),
                    title: sanitize(row.querySelector('[data-card-field="title"]')?.value),
                    subtitle: sanitize(row.querySelector('[data-card-field="subtitle"]')?.value),
                    link: sanitize(row.querySelector('[data-card-field="link"]')?.value),
                };
            };

            const sync = () => {
                const cards = Array.from(list.querySelectorAll('[data-card-item]')).map(readRow);
                jsonField.value = JSON.stringify(cards);
            };

            const setIndexLabels = () => {
                Array.from(list.querySelectorAll('[data-card-item]')).forEach((row, index) => {
                    const label = row.querySelector('[data-card-number]');
                    if (label) {
                        label.textContent = index + 1;
                    }
                });
            };

            const bindRow = (row) => {
                const removeButton = row.querySelector('[data-card-remove]');
                const inputs = row.querySelectorAll('input, textarea, select');

                removeButton?.addEventListener('click', () => {
                    row.remove();
                    setIndexLabels();
                    sync();
                });

                inputs.forEach((input) => {
                    input.addEventListener('input', sync);
                    input.addEventListener('change', sync);
                });
            };

            const buildRow = (card = {}) => {
                const rowHtml = template.innerHTML
                    .replaceAll('__IMAGE_NAME__', 'card_image_' + Math.random().toString(36).slice(2))
                    .replaceAll('__IMAGE_VALUE__', '');

                const wrapper = document.createElement('div');
                wrapper.innerHTML = rowHtml.trim();

                const row = wrapper.firstElementChild;

                const imageField = row.querySelector('[data-card-field="image"] input');
                const titleField = row.querySelector('[data-card-field="title"]');
                const subtitleField = row.querySelector('[data-card-field="subtitle"]');
                const linkField = row.querySelector('[data-card-field="link"]');

                if (imageField) {
                    imageField.value = sanitize(card.image);
                    imageField.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (titleField) {
                    titleField.value = sanitize(card.title);
                }

                if (subtitleField) {
                    subtitleField.value = sanitize(card.subtitle);
                }

                if (linkField) {
                    linkField.value = sanitize(card.link);
                }

                bindRow(row);

                return row;
            };

            const render = (cards) => {
                list.innerHTML = '';
                (cards.length ? cards : [{}]).forEach((card) => {
                    list.appendChild(buildRow(card));
                });
                setIndexLabels();
                sync();
            };

            addButton?.addEventListener('click', () => {
                list.appendChild(buildRow({}));
                setIndexLabels();
                sync();
            });

            render(defaults);

            try {
                const existing = jsonField.value ? JSON.parse(jsonField.value || '[]') : [];
                if (Array.isArray(existing) && existing.length) {
                    render(existing);
                }
            } catch (error) {
                render(defaults);
            }

            root.closest('form')?.addEventListener('submit', sync);
        })();
    </script>
@endonce
