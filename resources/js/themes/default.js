// =============================================================================
// filament-rekuest-theme — default variant entrypoint
//
// Vite bundles this file into:
//   - dist/themes/default.js   (this module, minified)
//   - dist/themes/default.css  (the SCSS import below, minified)
//
// Both are injected inline by the plugin via Filament render hooks.
// =============================================================================

import '../../scss/themes/default.scss';
import '../number-input.js';

console.log(
    '%cFilament Theme by %cRekuest Srl%c · https://www.rekuest.com',
    'color: inherit;',
    'color: #dc2228; font-weight: bold;',
    'color: inherit;',
);
