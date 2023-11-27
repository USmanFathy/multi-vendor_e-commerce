<?php

return [
    [
        'icon'  => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard',
        'ability' => 'dashboard.view'
    ],
    [
        'icon'  => 'far fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'categories.*',
        'ability' => 'categories.view'

    ],
    [
        'icon'  => 'fas fa-box nav-icon',
        'route' => 'products.index',
        'title' => 'Products',
        'badge' => 'New',
        'active' => 'products.*',
        'ability' => 'products.view'

    ],
    [
        'icon'  => 'fas fa-shield nav-icon',
        'route' => 'roles.index',
        'title' => 'Roles',
        'badge' => 'New',
        'active' => 'roles.*',
        'ability' => 'roles.view'

    ],
    [
        'icon'  => 'fas fa-users nav-icon',
        'route' => 'admins.index',
        'title' => 'Admin',
        'badge' => 'New',
        'active' => 'admins.*',
        'ability' => 'admins.view'
    ],
//    [
//        'icon'  => 'far fa-user nav-icon',
//        'route' => 'users.index',
//        'title' => 'User',
//        'badge' => 'New',
//        'active' => 'users.*',
//        'ability' => 'admins.view'
//    ],
];
