<?php

require __DIR__.'/config_with_app.php'; 

$di  = new \Anax\DI\CDIFactoryDefault(); 


$app = new \Anax\Kernel\CAnax($di); 
//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');
//$app->theme->addStylesheet('css/navbar.css');

$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Home");

    //$content = $app->fileContent->get('tema.md');
    //$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	$content = $app->fileContent->get('typography.html');

    

    $app->views->addString('<b>Testa lite olika teman här ovan </b>', 'main')
				->addString('<i class="fa fa-level-up"></i>', 'main')
              
               ;
});

$app->router->add('regioner', function() use ($app) {
 
    //$app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});


$app->router->add('font', function() use ($app) {
 
	
    $app->theme->setTitle("Font-Awesome");
   
	$content = $app->fileContent->get('theme.html');
    $app->views->addString($content, 'main')
				->addString('Sidebar<br/>', 'sidebar')
				->addString('<i class="fa fa-meh-o"></i>', 'sidebar')
				->addString('<i class="fa fa-meh-o fa-2x"></i>', 'sidebar')
				->addString('<i class="fa fa-meh-o fa-3x "></i>', 'sidebar')
				->addString('<i class="fa fa-meh-o fa-4x fa-fw"></i>', 'sidebar')
             ;
 
});

$app->router->add('typography', function() use ($app) {
 
	
    $app->theme->setTitle("Typography");
    $content = $app->fileContent->get('typography.html');

    $app->views->addString($content, 'main')
               ->addString($content, 'sidebar');
 
});


$app->router->handle();
$app->theme->render();