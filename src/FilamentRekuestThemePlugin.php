<?php

namespace Rekuest\FilamentRekuestTheme;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;

class FilamentRekuestThemePlugin implements Plugin
{
    /** @var array<string, string> */
    protected static array $assetCache = [];

    protected ?string $variant = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-rekuest-theme';
    }

    public function variant(string $variant): static
    {
        $this->variant = $variant;

        return $this;
    }

    public function getVariant(): string
    {
        return $this->variant ?? config('filament-rekuest-theme.default', 'default');
    }

    public function register(Panel $panel): void
    {
        $panel
            ->topNavigation()
            ->maxContentWidth(Width::Full)
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): string => $this->renderInlineStyle(),
            )
            ->renderHook(
                PanelsRenderHook::SCRIPTS_AFTER,
                fn (): string => $this->renderInlineScript(),
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    protected function renderInlineStyle(): string
    {
        $path = $this->resolveAssetPath('css');

        if ($path === null) {
            return '';
        }

        $css = $this->readAsset($path);

        if ($css === '') {
            return '';
        }

        return '<style data-filament-rekuest-theme="' . e($this->getVariant()) . '">' . $css . '</style>';
    }

    protected function renderInlineScript(): string
    {
        $path = $this->resolveAssetPath('js');

        if ($path === null) {
            return '';
        }

        $js = $this->readAsset($path);

        if ($js === '') {
            return '';
        }

        return '<script type="module" data-filament-rekuest-theme="' . e($this->getVariant()) . '">' . $js . '</script>';
    }

    protected function resolveAssetPath(string $extension): ?string
    {
        $variants = config('filament-rekuest-theme.variants', []);
        $variant = $this->getVariant();

        if (! array_key_exists($variant, $variants)) {
            return null;
        }

        $path = $variants[$variant]['path'] ?? null;

        if ($path === null) {
            return null;
        }

        // The config "path" points at the compiled CSS. The JS sibling lives
        // next to it with the same basename (dist/themes/<key>.css ↔ .js).
        $relative = $extension === 'css'
            ? $path
            : preg_replace('/\.css$/', '.js', $path);

        $absolute = realpath(__DIR__ . '/../' . ltrim($relative, '/'));

        return ($absolute !== false && is_file($absolute)) ? $absolute : null;
    }

    protected function readAsset(string $absolute): string
    {
        return static::$assetCache[$absolute] ??= (string) file_get_contents($absolute);
    }
}
