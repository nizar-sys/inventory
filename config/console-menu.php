<?php

$menuItems = [
    [
        'items' => [
            [
                'title' => 'Dashboard',
                'icon' => 'ri-home-smile-line',
                'route' => 'dashboard',
                'active' => 'dashboard',
                'submenu' => []
            ]
        ]
    ],
    [
        'header' => 'User Managements',
        'items' => [
            [
                'title' => 'Roles & Permissions',
                'icon' => 'ri-lock-2-line',
                'route' => '',
                'active' => ['permissions.*', 'roles.*'],
                'submenu' => [
                    [
                        'title' => 'Permission',
                        'route' => 'permissions.index',
                        'active' => 'permissions.*'
                    ],
                    [
                        'title' => 'Roles',
                        'route' => 'roles.index',
                        'active' => 'roles.*'
                    ]
                ]
            ],
            [
                'title' => 'Users',
                'icon' => 'ri-user-line',
                'route' => 'users.index',
                'active' => 'users.*',
                'submenu' => []
            ]
        ]
    ],
    [
        'header' => 'Master Data',
        'items' => [
            [
                'title' => 'Warehouses',
                'icon' => 'ri-store-2-line',
                'route' => 'warehouses.index',
                'active' => 'warehouses.*',
                'submenu' => []
            ],
            [
                'title' => 'Suppliers',
                'icon' => 'ri-truck-line',
                'route' => 'suppliers.index',
                'active' => 'suppliers.*',
                'submenu' => []
            ]
        ]
    ],
    [
        'header' => 'Products',
        'items' => [
            [
                'title' => 'Categories',
                'icon' => 'ri-folder-info-line',
                'route' => 'categories.index',
                'active' => 'categories.*',
                'submenu' => []
            ],
            [
                'title' => 'Products',
                'icon' => 'ri-shopping-bag-line',
                'route' => '',
                'active' => ['products.*', 'stocks.*'],
                'submenu' => [
                    [
                        'title' => 'List',
                        'route' => 'products.index',
                        'active' => 'products.*'
                    ],
                    [
                        'title' => 'Stock',
                        'route' => 'stocks.index',
                        'active' => 'stocks.*'
                    ]
                ]
            ],
            [
                'title' => 'Stock Opname',
                'icon' => 'ri-file-list-3-line',
                'route' => 'stock-opnames.index',
                'active' => 'stock-opnames.*',
                'submenu' => []
            ]
        ]
    ],
    [
        'header' => 'Settings',
        'items' => [
            [
                'title' => 'Profile',
                'icon' => 'ri-settings-4-line',
                'route' => 'profile.edit',
                'active' => 'profile.*',
                'submenu' => []
            ]
        ]
    ]
];

return $menuItems;
