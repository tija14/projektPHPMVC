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

        // This is a menu item
        'back'  => [
            'text'  => '&lt&lt Tillbaka',
            'url'   => '../me.php',
            'title' => 'back'
        ],
 
        // This is a menu item
        'regioner' => [
            'text'  =>'Regioner',
            'url'   => 'regioner',
            'title' => 'regioner'
        ],
		
		
		'font' => [
            'text'  =>'Font-Awesome',
            'url'   => 'font',
            'title' => 'font'
        ],
		'typography' => [
            'text'  =>'Typography',
            'url'   => 'typography',
            'title' => 'typography'
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

	'stylesheets' => ['css/style.css', 'css/navbar_me.css'],
];
