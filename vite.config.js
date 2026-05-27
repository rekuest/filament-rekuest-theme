import { defineConfig } from 'vite';
import { resolve } from 'node:path';
import { readdirSync } from 'node:fs';

// Auto-discover every variant entry under resources/js/themes/.
// Each entry imports its own SCSS counterpart in resources/scss/themes/.
const themesDir = resolve(__dirname, 'resources/js/themes');

const inputs = Object.fromEntries(
    readdirSync(themesDir)
        .filter((file) => file.endsWith('.js'))
        .map((file) => [
            `themes/${file.replace(/\.js$/, '')}`,
            resolve(themesDir, file),
        ]),
);

export default defineConfig({
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        cssCodeSplit: true,
        cssMinify: true,
        minify: 'esbuild',
        sourcemap: false,
        rollupOptions: {
            input: inputs,
            output: {
                format: 'es',
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: (assetInfo) => {
                    const name = assetInfo.name ?? '';

                    if (name.endsWith('.css')) {
                        return 'themes/[name].[ext]';
                    }

                    return '[name].[ext]';
                },
            },
        },
    },
});
