import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                'resources/js/auth/script.js',
                'resources/js/console/categories/category_validation_script.js',
                'resources/js/console/categories/script.js',
                'resources/js/console/permissions/script.js',
                'resources/js/console/product-stocks/create_script.js',
                'resources/js/console/product-stocks/edit_script.js',
                'resources/js/console/product-stocks/script.js',
                'resources/js/console/products/create_script.js',
                'resources/js/console/products/edit_script.js',
                'resources/js/console/products/script.js',
                'resources/js/console/roles/script.js',
                'resources/js/console/stock-opnames/create_script.js',
                'resources/js/console/stock-opnames/script.js',
                'resources/js/console/suppliers/script.js',
                'resources/js/console/suppliers/supplier_validation_script.js',
                'resources/js/console/users/edit_script.js',
                'resources/js/console/users/script.js',
                'resources/js/console/users/show_script.js',
                'resources/js/console/warehouses/script.js',
                'resources/js/console/warehouses/warehouse_validation_script.js',

                'resources/js/profile/script.js',
                'resources/js/search/script.js',

                'resources/js/app-logistics-dashboard.js',
                'resources/js/bootstrap.js',
                'resources/js/main.js',
            ],
            refresh: true,
        }),
    ],
});
