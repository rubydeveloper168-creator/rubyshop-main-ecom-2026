@php
    use Botble\Media\Facades\RvMedia;
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
                    <div class="image-box image-box-__IMAGE_NAME__" data-card-field="image" data-card-image-wrapper>
                        <input class="image-data" name="__IMAGE_NAME__" type="hidden" value="">

                        <div style="width: 8rem" class="preview-image-wrapper mb-1 preview-image-wrapper-not-allow-thumb">
                            <div class="preview-image-inner">
                                <a
                                    data-bb-toggle="image-picker-choose"
                                    data-target="popup"
                                    class="image-box-actions"
                                    data-result="__IMAGE_NAME__"
                                    data-action="select-image"
                                    data-allow-thumb="false"
                                    href="#"
                                >
                                    <x-core::image
                                        class="preview-image default-image"
                                        data-default="{{ RvMedia::getDefaultImage() }}"
                                        src="{{ RvMedia::getDefaultImage() }}"
                                        alt="{{ trans('core/base::base.preview_image') }}"
                                    />
                                    <span class="image-picker-backdrop"></span>
                                </a>
                                <x-core::button
                                    style="display: none; --bb-btn-font-size: 0.5rem;"
                                    class="image-picker-remove-button p-0"
                                    :pill="true"
                                    data-bb-toggle="image-picker-remove"
                                    size="sm"
                                    icon="ti ti-x"
                                    :icon-only="true"
                                    :tooltip="trans('core/base::forms.remove_image')"
                                />
                            </div>
                        </div>

                        <a
                            data-bb-toggle="image-picker-choose"
                            data-target="popup"
                            data-result="__IMAGE_NAME__"
                            data-action="select-image"
                            data-allow-thumb="false"
                            href="#"
                        >
                            {{ trans('core/base::forms.choose_image') }}
                        </a>
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
            const resolvePreviewUrl = (imageUrl, fallback) => {
                const value = sanitize(imageUrl);

                if (!value) {
                    return fallback;
                }

                if (/^(https?:)?\/\//i.test(value) || value.startsWith('data:')) {
                    return value;
                }

                return `/${value.replace(/^\/+/, '')}`;
            };

            const getImageBox = (row) => row.querySelector('[data-card-field="image"]');

            const updateImagePreview = (row, imageUrl) => {
                const imageBox = getImageBox(row);
                if (!imageBox) {
                    return;
                }

                const input = imageBox.querySelector('.image-data');
                const preview = imageBox.querySelector('.preview-image');
                const removeButton = imageBox.querySelector('[data-bb-toggle="image-picker-remove"]');

                if (input) {
                    input.value = sanitize(imageUrl);
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (preview) {
                    preview.setAttribute('src', resolvePreviewUrl(imageUrl, preview.dataset.default || preview.getAttribute('src')));

                    if (imageUrl) {
                        preview.classList.remove('default-image');
                    } else {
                        preview.classList.add('default-image');
                    }
                }

                if (removeButton) {
                    removeButton.style.display = imageUrl ? '' : 'none';
                }
            };

            const initImagePicker = (row) => {
                const chooseButton = row.querySelector('[data-bb-toggle="image-picker-choose"][data-target="popup"]');

                if (!chooseButton || typeof $.fn.rvMedia !== 'function') {
                    return;
                }

                $(chooseButton).rvMedia({
                    multiple: false,
                    filter: 'image',
                    view_in: 'all_media',
                    onSelectFiles: (files, $el) => {
                        const firstImage = _.first(files);
                        const $imageBox = $el.closest('.image-box');
                        const allowThumb = $el.data('allow-thumb');
                        const imageUrl = firstImage?.url || firstImage?.full_url || '';
                        const previewUrl = allowThumb && firstImage?.thumb ? firstImage.thumb : firstImage?.full_url || imageUrl;

                        $imageBox.find('.image-data').val(imageUrl).trigger('change');
                        $imageBox.find('.preview-image').attr('src', previewUrl).removeClass('default-image');
                        $imageBox.find('[data-bb-toggle="image-picker-remove"]').show();

                        sync();
                    },
                });
            };

            const readRow = (row) => {
                const imageField = row.querySelector('[data-card-field="image"] .image-data') || row.querySelector('[data-card-field="image"] input') || row.querySelector('[data-card-field="image"]');

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

                const titleField = row.querySelector('[data-card-field="title"]');
                const subtitleField = row.querySelector('[data-card-field="subtitle"]');
                const linkField = row.querySelector('[data-card-field="link"]');

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
                initImagePicker(row);
                updateImagePreview(row, sanitize(card.image));

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
