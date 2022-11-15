<?php

return [
    'access' => [
        'list_accounts' => 'list-accounts',
        'create_account' => 'create-account',
        'edit_account' => 'edit-account',
        'delete_account' => 'delete-account',

        'list_roles' => 'list-roles',
        'create_role' => 'create-role',
        'edit_role' => 'edit-role',
        'delete-role' => 'delete_role',

        'list_permissions' => 'list-permissions',
        'create_permission' => 'create-permission',
        'edit_permission' => 'edit-permission',
        'delete_permission' => 'delete-permission',

        'list_categories' => 'list-categories',
        'create_category' => 'create-category',
        'edit_category' => 'edit-category',
        'delete_category' => 'delete-category',

        'list_products' => 'list-products',
        'create_product' => 'create-product',
        'edit_product' => 'edit-product',
        'delete_product' => 'delete-product',
    ],

    'module_table' => [
        'Account',
        'Role',
        'Permission',
        'Category'
    ],

    'module_children' => [
        'List',
        'Create',
        'Edit',
        'Delete',
    ]
];
