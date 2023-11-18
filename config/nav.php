<?php

return [
    [
        'icon'  => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard'
    ],
    [
        'icon'  => 'far fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'categories.*'
    ],
    [
        'icon'  => 'far fa-box nav-icon',
        'route' => 'products.index',
        'title' => 'Products',
        'badge' => 'New',
        'active' => 'products.*'
    ],
//    [
//        'icon'  => 'far fa-circle nav-icon',
//        'route' => 'categories.index',
//        'title' => 'Orders',
//        'badge' => 'New',
//        'active' => 'categories.*'
//    ],
];
