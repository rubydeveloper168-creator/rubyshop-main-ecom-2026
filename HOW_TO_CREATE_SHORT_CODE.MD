# How to Create a New Shortcode in This Project

This project uses **Botble shortcode** inside the `wowy` theme.

Important:
- Register shortcodes in `platform/themes/wowy/functions/shortcodes.php`
- Use `add_shortcode(...)` for registration
- Use `shortcode()->setAdminConfig(...)` for the admin form
- Put the Blade partial in `platform/themes/wowy/partials/shortcodes/`
- The shortcode picker in admin reads from `Shortcode::getAll()`

## 1. Where Shortcodes Are Loaded

Theme helper files are auto-loaded from:

`platform/themes/wowy/functions/`

So any `*.php` file in that folder is loaded by the theme boot process.  
For shortcodes, the main file is:

`platform/themes/wowy/functions/shortcodes.php`

If you add a shortcode anywhere else, the admin picker will not see it unless that file is loaded at runtime.

## 2. Register a Shortcode

Example:

```php
add_shortcode(
    'hero-video-mobile-image-ruby',
    __('Hero Video Mobile Image Ruby'),
    __('Hero section with video on desktop and image on mobile'),
    function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.hero-video-mobile-image-ruby', [
            'attributes' => $shortcode->toArray(),
        ]);
    }
);
```

Rules:
- The first argument is the shortcode key
- That key becomes the editor syntax, for example:

```text
[hero-video-mobile-image-ruby][/hero-video-mobile-image-ruby]
```

- The second argument is the display name in admin
- The third argument is the description in admin
- The callback returns rendered HTML

## 3. Add Admin Configuration

Example:

```php
shortcode()->setAdminConfig('hero-video-mobile-image-ruby', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add('desktop_video', MediaFileField::class, MediaFileFieldOption::make()->label(__('Desktop video')))
        ->add('desktop_poster', MediaImageField::class, MediaImageFieldOption::make()->label(__('Desktop poster image')))
        ->add('mobile_image', MediaImageField::class, MediaImageFieldOption::make()->label(__('Mobile image')))
        ->add('title', TextField::class, TextFieldOption::make()->label(__('Title')))
        ->add('subtitle', TextareaField::class, TextareaFieldOption::make()->label(__('Subtitle')))
        ->add('button_text', TextField::class, TextFieldOption::make()->label(__('Button text')))
        ->add('button_link', TextField::class, TextFieldOption::make()->label(__('Button URL')));
});
```

The admin form is what appears after clicking **Use** in the shortcode modal.

## 4. Add a Preview Image

This is optional, but recommended.

```php
shortcode()->setPreviewImage(
    'hero-video-mobile-image-ruby',
    asset('vendor/core/packages/theme/images/ui-blocks/youtube-video.jpg')
);
```

If you do not set a preview image, the modal will show the placeholder image.

## 5. Create the Blade Partial

Create:

`platform/themes/wowy/partials/shortcodes/hero-video-mobile-image-ruby.blade.php`

Example structure:

```blade
@php
    $desktopVideo = Arr::get($attributes, 'desktop_video');
    $desktopPoster = Arr::get($attributes, 'desktop_poster');
    $mobileImage = Arr::get($attributes, 'mobile_image');
@endphp

<section class="hero-shortcode">
    <div class="desktop-only">
        <video controls playsinline preload="metadata" poster="{{ RvMedia::getImageUrl($desktopPoster) }}">
            <source src="{{ RvMedia::getImageUrl($desktopVideo) }}" type="video/mp4">
        </video>
    </div>

    <div class="mobile-only">
        <img src="{{ RvMedia::getImageUrl($mobileImage) }}" alt="">
    </div>
</section>
```

## 6. How Admin Shows Shortcodes

The shortcode modal in admin reads from:

`Shortcode::getAll()`

That means the shortcode must be registered during the current request.

The editor field in page form already supports shortcodes:

`platform/packages/page/src/Forms/PageForm.php`

It uses:

```php
->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes())
```

So for pages, you do not need extra wiring if the shortcode is registered correctly.

## 7. Where The Shortcode Picker Comes From

The admin modal is rendered from:

`platform/packages/shortcode/resources/views/partials/shortcode-modal.blade.php`

It loops over all registered shortcodes and shows only items that have a `name`.

If your shortcode does not appear there, one of these is wrong:
- the shortcode file was not loaded
- the PHP cache/compiled view is stale
- the admin page is still using an old browser session
- the shortcode key was registered somewhere outside the theme autoload path

## 8. Troubleshooting

If the new shortcode does not show in admin:

1. Confirm it is inside `platform/themes/wowy/functions/shortcodes.php`
2. Confirm it uses `add_shortcode(...)`
3. Confirm it uses `shortcode()->setAdminConfig(...)`
4. Confirm `platform/themes/wowy/functions/` is loaded on this request
5. Clear Laravel compiled/cache files
6. Hard refresh the browser

For this project, the page editor should already allow shortcodes.  
If the shortcode still does not appear, the problem is usually cache or registration order, not the editor field.

## 9. Example Shortcode

```text
[hero-video-mobile-image-ruby
    desktop_video="storage/ads/vdo.mp4"
    desktop_poster="storage/ads01/30l/m30l-hero.jpg"
    mobile_image="storage/ads01/30l/m30l-hero.jpg"
    title="เครื่องมือช่างเพื่อมืออาชีพ"
    subtitle="งานจบไว มาตรฐานสูง พร้อมบริการจาก RUBYSHOP"
    button_text="ดูสินค้า"
    button_link="/product-categories/airless-sprayer"
][/hero-video-mobile-image-ruby]
```

