<p align="center">
    <a href="https://www.rekuest.com" target="_blank" rel="noopener">
        <img src="docs/logo-rekuest.svg" alt="Rekuest" width="200">
    </a>
</p>

# Filament Rekuest Theme

> ⚠️ **Work in progress** — this package is still under active development. APIs, variants and tokens may change without notice until the first stable release. Use in production at your own risk.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rekuest/filament-rekuest-theme.svg?style=flat-square)](https://packagist.org/packages/rekuest/filament-rekuest-theme)
[![Total Downloads](https://img.shields.io/packagist/dt/rekuest/filament-rekuest-theme.svg?style=flat-square)](https://packagist.org/packages/rekuest/filament-rekuest-theme)
[![License](https://img.shields.io/packagist/l/rekuest/filament-rekuest-theme.svg?style=flat-square)](LICENSE.md)
[![Filament](https://img.shields.io/badge/Filament-5.x-F59E0B.svg?style=flat-square)](https://filamentphp.com)

An **enterprise-grade theme** for [Filament](https://filamentphp.com) **v5.x** panels — purpose-built for the kind of admin surfaces operators stare at for eight hours a day.

The package is opinionated about four things:

- **Clean, low-noise UI** — flattened cards, calmer borders, generous spacing, no decorative shadows. The interface stays out of the way so the data is what you read.
- **Eye-friendly color system** — desaturated brand-blue ramps and tuned semantic palettes (success / warning / danger / info) chosen for long-session legibility, with parity between light and dark mode so users can switch without losing visual hierarchy.
- **Auto-configured ERP layout** — the plugin enables Filament's top navigation, runs list / table pages at full viewport width (no wasted whitespace next to wide tables), and boxes record detail pages (view / edit / create) to a comfortable **1440 px** reading width, centered. No extra `->topNavigation()` / `->maxContentWidth()` calls in your panel provider.
- **Built for ERP / management software** — sticky form actions, right-aligned numeric inputs, predictable typography rhythm, accessible contrast ratios (WCAG AA+) on action buttons — the small structural defaults that distinguish a professional back-office from a generic dashboard.

Ships with precompiled CSS + minified JS, injected inline by the plugin: no Tailwind build step, no asset-publish dance, no Node required in the host application.

## Features

- Fully **light/dark compatible** (Filament's `.dark` class toggle).
- Precompiled CSS shipped in `dist/` and **injected inline** into the panel — zero publish step, no `filament:assets` to run after switching variant.
- Standard Filament v5 **plugin** API (`->plugin(FilamentRekuestThemePlugin::make())`).
- Per-panel configuration: different panels can use different variants.
- Easy to extend: add your own variants via the published config.

> The theme is shipped as override CSS (custom properties + targeted rules), not a full Tailwind build, which is why inline injection is efficient here.

## Requirements

- PHP `^8.2`
- Laravel `^11.28` · `^12.0` · `^13.0`
- Filament `^5.0`

## Installation

```bash
composer require rekuest/filament-rekuest-theme
```

(Optional) Publish the config file:

```bash
php artisan vendor:publish --tag="filament-rekuest-theme-config"
```

## Usage

Register the plugin on any Filament panel:

```php
use Filament\Panel;
use Rekuest\FilamentRekuestTheme\FilamentRekuestThemePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(FilamentRekuestThemePlugin::make());
}
```

That's it — the theme CSS / JS are injected inline by the plugin and the bundled `default` variant is applied automatically.

If you have registered additional variants (either your own — see the *Adding a variant* section — or shipped by future releases of this package), select one explicitly with `->variant()`:

```php
->plugin(
    FilamentRekuestThemePlugin::make()
        ->variant('my-custom-variant'),
);
```

### Available variants

| Key       | Description                              | Light | Dark |
|-----------|------------------------------------------|:-----:|:----:|
| `default` | Neutral, balanced theme. Sensible start. |   ✓   |  ✓   |

> More variants are coming. Contributions welcome — see *Adding a variant* below.

## Configuration

After publishing the config file, you can register your own variants pointing
at any CSS file shipped by your application or another package:

```php
// config/filament-rekuest-theme.php
return [
    'default' => 'default',

    'variants' => [
        'default' => [
            'label' => 'Default',
            'path'  => 'dist/themes/default.css',
        ],

        'my-custom' => [
            'label' => 'My Custom',
            'path'  => 'dist/themes/my-custom.css',
        ],
    ],
];
```

Paths are resolved relative to the package root for shipped variants. For app-level
custom paths you can pass an absolute path.

## Dark mode

Filament toggles the `.dark` class on the `<html>` element. Every variant in this
package defines both light (`:root`) and dark (`.dark`) tokens, so the active
appearance follows Filament's user preference automatically.

You don't need to do anything to enable dark mode — just make sure your panel
allows it (`->darkMode()` is the Filament default).

## Adding a variant

1. Add a JS entrypoint under `resources/js/themes/<key>.js`. It only needs
   to import the matching SCSS file and any optional JS utilities:
   ```js
   import '../../scss/themes/<key>.scss';
   import '../number-input-wheel.js'; // optional
   ```
2. Add an SCSS file under `resources/scss/themes/<key>.scss`. Use
   `resources/scss/themes/default.scss` as a template — it exposes light/dark
   token pairs and `@include light { ... }` / `@include dark { ... }` blocks
   for targeted overrides.
3. Run `npm install && npm run build` from the package root. Vite bundles
   each entry into `dist/themes/<key>.css` and `dist/themes/<key>.js`
   (minified).
4. Register the variant in `config/filament-rekuest-theme.php`.
5. Open a PR — or keep it private in your own fork.

The compiled `dist/themes/*.{css,js}` files are committed to the repository so
that consumers installing via Composer/Packagist get a working theme out of the
box without needing Node installed.

## Development

```bash
composer install
npm install
npm run build      # vite build → dist/themes/*.{css,js} (minified)
npm run dev        # vite watch mode

composer test      # run Pest test suite
```

Available SCSS helpers (see `resources/scss/abstracts/_mixins.scss`):

| Helper | Purpose |
|---|---|
| `@include token($name, $light, $dark)` | Declare a CSS custom property pair for light and dark modes in one line. |
| `@include light { ... }` | Wrap rules that should only apply in light mode. |
| `@include dark { ... }` | Wrap rules that should only apply in dark mode. |

## Credits

- [Rekuest Srl](https://www.rekuest.com)

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.
