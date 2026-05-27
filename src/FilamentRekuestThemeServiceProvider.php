<?php

namespace Rekuest\FilamentRekuestTheme;

use Illuminate\Support\ServiceProvider;

class FilamentRekuestThemeServiceProvider extends ServiceProvider
{
    public static string $name = 'filament-rekuest-theme';

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/' . static::$name . '.php',
            static::$name,
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/' . static::$name . '.php' => config_path(static::$name . '.php'),
        ], static::$name . '-config');
    }
}
