<?php

return [

	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],
    'logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],

    'cart' => [
        'controller' => 'cart',
        'action' => 'cart',
    ],
    'cart/add' => [
    'controller' => 'cart',
    'action' => 'add',
],

    'cart/del' => [
        'controller' => 'cart',
        'action' => 'del',
    ],
    'cart/send' => [
        'controller' => 'cart',
        'action' => 'send',
    ],
    'menu' => [
        'controller' => 'menu',
        'action' => 'menu',
    ],
    'menu/{name:[-+!\w]+}/{id:\d+}' => [
        'controller' => 'menu',
        'action' => 'category',
    ],
    //Товары за типом товара
    '{category:[-+!\w]+}/{categoryid:\d+}/{type:[-+!\w]+}/{typeid:\d+}' => [
        'controller' => 'menu',
        'action' => 'catalog',
    ],
    //----------------------------------------------
	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],
    'account/activate' => [
        'controller' => 'account',
        'action' => 'activate',
    ],
    'account/cURL' => [
        'controller' => 'account',
        'action' => 'cURL',
    ],'account/pURL' => [
        'controller' => 'account',
        'action' => 'pURL',
    ],
    'cart/cURL' => [
        'controller' => 'cart',
        'action' => 'cURL',
    ],'cart/pURL' => [
        'controller' => 'cart',
        'action' => 'pURL',
    ],
    'account/profile' => [
        'controller' => 'account',
        'action' => 'profile',
    ],
    'account/cart' => [
        'controller' => 'account',
        'action' => 'cart',
    ],
    'account/send' => [
        'controller' => 'account',
        'action' => 'send',
    ],
    'account/wishlist' => [
        'controller' => 'account',
        'action' => 'wishlist',
    ],
    'account/waitlist' => [
        'controller' => 'account',
        'action' => 'waitlist',
    ],
    'account/buylist' => [
        'controller' => 'account',
        'action' => 'buylist',
    ],
    'catalog' => [
        'controller' => 'catalog',
        'action' => 'view',
    ],
    'catalog/search' => [
        'controller' => 'catalog',
        'action' => 'search',
    ],
    'product/{name:[-+!\w]+}/{category:\d+}/{id:\d+}' => [
        'controller' => 'product',
        'action' => 'view',
    ],
    'admin/login' => [
        'controller' => 'admin',
        'action' => 'login',
    ],
    'admin/panel' => [
        'controller' => 'admin',
        'action' => 'panel',
    ],
    'admin/catalog' => [
        'controller' => 'admin',
        'action' => 'catalog',
    ],
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
    ],
    'admin/type' => [
        'controller' => 'admin',
        'action' => 'type',
    ],
    'admin/buylist' => [
        'controller' => 'admin',
        'action' => 'buylist',
    ],
    'admin/waitlist' => [
        'controller' => 'admin',
        'action' => 'waitlist',
    ],
    'admin/wishlist' => [
        'controller' => 'admin',
        'action' => 'wishlist',
    ],
    'admin/cart' => [
        'controller' => 'admin',
        'action' => 'cart',
    ],'admin/category' => [
        'controller' => 'admin',
        'action' => 'category',
    ],'admin/characteristic' => [
        'controller' => 'admin',
        'action' => 'characteristic',
    ],'admin/add' => [
        'controller' => 'admin',
        'action' => 'add',
    ],'admin/class' => [
        'controller' => 'admin',
        'action' => 'class',
    ],
];