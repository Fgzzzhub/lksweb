<?php

return [
    ''                          => ['HomeController', 'index'],

    'destinations'              => ['DestinationsController', 'index'],
    'destinations/detail'       => ['DestinationsController', 'show'],

    'culture'                   => ['CultureController', 'index'],
    'culinary'                  => ['CulinaryController', 'index'],

    'admin'                     => ['AdminDashboardController', 'index'],
    'admin/login'               => ['AdminAuthController', 'login'],
    'admin/logout'              => ['AdminAuthController', 'logout'],
    'admin/categories'          => ['AdminCategoriesController', 'index'],

    'admin/categories/create'   => ['AdminCategoriesController', 'create'],
    'admin/categories/edit'     => ['AdminCategoriesController', 'edit'],
    'admin/categories/delete'   => ['AdminCategoriesController', 'delete'],

    'admin/destinations'        => ['AdminDestinationsController', 'index'],
    'admin/destinations/create' => ['AdminDestinationsController', 'create'],
    'admin/destinations/edit'   => ['AdminDestinationsController', 'edit'],
    'admin/destinations/delete' => ['AdminDestinationsController', 'delete'],
];
