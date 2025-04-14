import { PrimeVueResolver } from '@primevue/auto-import-resolver';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import Components from 'unplugin-vue-components/vite';
import { defineConfig } from 'vite';
export default defineConfig({
    css: {
        preprocessorOptions: {
          scss: {
            additionalData: `@import "primevue/resources/themes/lara-light-indigo/theme.css";`
          }
        }
      },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [
              PrimeVueResolver()
            ]
          }),
    ],
    server:{
        https: false,
        // host: '192.168.176.186'
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
