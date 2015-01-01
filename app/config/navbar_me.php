<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
	
    // Here comes the menu strcture
    'items' => [

		'home'  => [
            'text'  => 'Hem',
            'url'   => 'home',
            'title' => 'hem'
        ],
        // This is a menu item
        'questions'  => [
            'text'  => 'Frågor',
            'url'   => 'questions',
            'title' => 'frågor'
        ],
 
        // This is a menu item
        'taggar' => [
            'text'  =>'Taggar',
            'url'   => 'tags',
            'title' => 'taggar'
        ],
	
		
		'users'  => [ 
            'text'  => 'Användare', 
            'url'   => $this->di->get('url')->create('users/list'), 
            'title' => 'users' 
        ], 
		 'about' => [
            'text'  =>'Om oss',
            'url'   => 'about',
            'title' => 'about'
        ],
	
		
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getRoute()) {
                return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },

	//'stylesheets' => ['css/style.css', 'css/navbar.css'],
];
