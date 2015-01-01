<?php

require __DIR__.'/config_with_app.php'; 

$di  = new \Anax\DI\CDIFactoryDefault(); 

$di->set('CommentController', function() use ($di) { 
    $controller = new Phpmvc\Comment\CommentController(); 
    $controller->setDI($di); 
    return $controller; 
}); 
$app = new \Anax\Kernel\CAnax($di); 

//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
//$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
//$app->theme->setVariable('title', "En me-sida");




$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Me");

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

     $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
		'params'     => [''], 
    ]);
 
    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
		'id'        => null, 
        'pageId'    => '', 
    ]);
	
	$app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
	
	
});



$app->router->add('source', function() use ($app) {
			
	$app->theme->addStylesheet('css/source.css');
	$app->theme->setTitle("Källkod");
	
	$source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
	
	 $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});
 
$app->router->add('redovisning', function() use ($app) {
 
    $app->theme->setTitle("Redovisning");
     
	$content = $app->fileContent->get('redovisning.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
	$byline  = $app->fileContent->get('byline.md');
	$byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    
	
	$app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
		'params'     => ['redovisning'], 
    ]);
 
    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
		'id'        => null, 
        'pageId'    => 'redovisning', 
    ]);
	
	$app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
 
});

 
 
$app->router->handle();
$app->theme->render();