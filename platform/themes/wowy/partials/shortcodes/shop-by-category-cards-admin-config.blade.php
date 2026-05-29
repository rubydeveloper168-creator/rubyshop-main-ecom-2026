@php
    use Botble\Base\Facades\Form;
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];

    $cardsValue = Arr::get($attributes, 'cards', []);

    if (is_string($cardsValue)) {
        $decodedCardsValue = base64_decode($cardsValue, true);

        if ($decodedCardsValue !== false) {
            $cardsValue = json_decode($decodedCardsValue, true) ?: [];
        } else {
            $cardsValue = json_decode($cardsValue, true) ?: [];
        }
    }

    if (! is_array($cardsValue)) {
        $cardsValue = [];
    }

    if (! Arr::isList($cardsValue)) {
        $cardsValue = array_values($cardsValue);
    }

    if (empty($cardsValue)) {
        for ($i = 1; $i <= 20; $i++) {
            $card = [
                'image' => Arr::get($attributes, "card{$i}_image"),
                'title' => Arr::get($attributes, "card{$i}_title"),
                'subtitle' => Arr::get($attributes, "card{$i}_subtitle"),
                'link' => Arr::get($attributes, "card{$i}_link"),
            ];

            if (filled($card['image']) || filled($card['title']) || filled($card['subtitle']) || filled($card['link'])) {
                $card['preview'] = $card['image']
                    ? RvMedia::getImageUrl($card['image'], null, false, RvMedia::getDefaultImage())
                    : RvMedia::getDefaultImage();

                $cardsValue[] = $card;
            }
        }
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
        <input type="text" name="button_link" value="{{ Arr::get($attributes, 'button_link', '/categories') }}" class="form-control" placeholder="/categories">
    </div>

    <div class="mb-3">
        <label class="form-label d-flex align-items-center justify-content-between">
            <span>{{ __('Cards') }}</span>
            <button type="button" class="btn btn-sm btn-primary" data-card-add>
                {{ __('Add card') }}
            </button>
        </label>

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
                        {!! Form::mediaImage('__CARD_IMAGE_NAME__', '__CARD_IMAGE_VALUE__', ['preview_image' => RvMedia::getDefaultImage()]) !!}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Title') }}</label>
                    <input type="text" class="form-control" data-card-field="title" name="__CARD_TITLE_NAME__" value="" placeholder="{{ __('Title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Subtitle') }}</label>
                    <input type="text" class="form-control" data-card-field="subtitle" name="__CARD_SUBTITLE_NAME__" value="" placeholder="{{ __('Subtitle') }}">
                </div>

                <div class="mb-0">
                    <label class="form-label">{{ __('Link') }}</label>
                    <input type="text" class="form-control" data-card-field="link" name="__CARD_LINK_NAME__" value="" placeholder="/product-categories/example">
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

            const isAdminPagesEdit = /^\/admin\/pages\/edit\/\d+/.test(window.location.pathname);
            const debugLog = (...args) => {
                if (!isAdminPagesEdit) {
                    return;
                }

                console.log('[Shop By Category Cards][admin]', ...args);
            };

            const list = root.querySelector('[data-card-list]');
            const template = root.querySelector('[data-card-template]');
            const addButton = root.querySelector('[data-card-add]');

            const defaults = @json($cardsValue);
            debugLog('init', {
                pathname: window.location.pathname,
                defaults,
            });

            const sanitize = (value) => (value ?? '').toString();

            const resolvePreviewUrl = (imageUrl, fallback) => {
                const value = sanitize(imageUrl);

                if (!value) {
                    return fallback;
                }

                if (/^(https?:)?\/\//i.test(value) || value.startsWith('data:')) {
                    return value;
                }

                return fallback;
            };

            const rowState = (row) => ({
                image: sanitize(row.querySelector('.image-data')?.value),
                title: sanitize(row.querySelector('[data-card-field="title"]')?.value),
                subtitle: sanitize(row.querySelector('[data-card-field="subtitle"]')?.value),
                link: sanitize(row.querySelector('[data-card-field="link"]')?.value),
            });

            const setRowNames = (row, index) => {
                const prefix = `card${index}`;
                const imageInput = row.querySelector('.image-data');
                const titleField = row.querySelector('[data-card-field="title"]');
                const subtitleField = row.querySelector('[data-card-field="subtitle"]');
                const linkField = row.querySelector('[data-card-field="link"]');

                if (imageInput) {
                    imageInput.name = `${prefix}_image`;
                }

                if (titleField) {
                    titleField.name = `${prefix}_title`;
                }

                if (subtitleField) {
                    subtitleField.name = `${prefix}_subtitle`;
                }

                if (linkField) {
                    linkField.name = `${prefix}_link`;
                }
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
                const defaultPreview = row.dataset.previewUrl || preview?.dataset.default || preview?.getAttribute('src');

                if (input) {
                    input.value = sanitize(imageUrl);
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (preview) {
                    preview.setAttribute('src', resolvePreviewUrl(imageUrl, defaultPreview));

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
                const chooseButton = row.querySelector('[data-bb-toggle="image-picker-choose"]');

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

                        debugLog('image selected', {
                            imageUrl,
                            previewUrl,
                        });
                    },
                });
            };

            const sync = () => {
                Array.from(list.querySelectorAll('[data-card-item]')).forEach((row, index) => {
                    setRowNames(row, index + 1);
                });

                const cards = Array.from(list.querySelectorAll('[data-card-item]')).map(rowState);
                debugLog('sync', cards);
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
                    sync();
                    setIndexLabels();
                });

                inputs.forEach((input) => {
                    input.addEventListener('input', sync);
                    input.addEventListener('change', sync);
                });
            };

            const buildRow = (card = {}, index = 1) => {
                const rowHtml = template.innerHTML
                    .replaceAll('__CARD_IMAGE_NAME__', `card${index}_image`)
                    .replaceAll('__CARD_IMAGE_VALUE__', sanitize(card.image))
                    .replaceAll('__CARD_IMAGE_PREVIEW__', sanitize(card.preview || ''))
                    .replaceAll('__CARD_TITLE_NAME__', `card${index}_title`)
                    .replaceAll('__CARD_SUBTITLE_NAME__', `card${index}_subtitle`)
                    .replaceAll('__CARD_LINK_NAME__', `card${index}_link`);

                const wrapper = document.createElement('div');
                wrapper.innerHTML = rowHtml.trim();

                const row = wrapper.firstElementChild;
                row.dataset.previewUrl = sanitize(card.preview || '');

                setRowNames(row, index);

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
                debugLog('row built', {
                    ...rowState(row),
                });

                return row;
            };

            const render = (cards) => {
                list.innerHTML = '';
                (cards.length ? cards : [{}]).forEach((card, index) => {
                    list.appendChild(buildRow(card, index + 1));
                });
                setIndexLabels();
                sync();
            };

            addButton?.addEventListener('click', () => {
                list.appendChild(buildRow({}, list.querySelectorAll('[data-card-item]').length + 1));
                setIndexLabels();
                sync();
            });

            render(defaults);

            root.closest('form')?.addEventListener('submit', sync);
        })();
    </script>
@endonce
