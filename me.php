<?php

require __DIR__.'/config_with_app.php'; 

$di  = new \Anax\DI\CDIFactoryDefault(); 

$di->set('form', '\Mos\HTMLForm\CForm'); 

$di->set('CommentController', function() use ($di) { 
    $controller = new Phpmvc\Comment\CommentController(); 
    $controller->setDI($di); 
    return $controller; 
}); 

$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/db_mysql.php');
    $db->connect();
    return $db;
});

$di->set('UsersController', function() use ($di) { 
    $controller = new \Anax\Users\UsersController(); 
    $controller->setDI($di); 
    return $controller; 
}); 

$app = new \Anax\Kernel\CAnax($di); 


$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$app->session(); 




$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Me");

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

	
	$app->views->add('me/page', [
        'content' => $content,
        
    ]);
	
	$app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
		'params'     => ['me'], 
    ]);
	
	/*$app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'edit',
		'params'     => ['me'], 
    ]);
	*/
    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
		'id'        => null, 
        'pageId'    => 'me', 
    ]);
	
	$app->views->add('me/page', [
       
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
 
	
	$app->views->add('me/page', [
        'content' => $content,
        
    ]);
	
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
	/*
	/*$app->db->dropTableIfExists('comment')->execute();
 
    $app->db->createTable(
        'comment',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'comment' => ['text(200)', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            
        ]
    )->execute();
	*/
	
	$app->views->add('me/page', [
        
        'byline' => $byline,
    ]);
	});
	
$app->router->add('setup', function() use ($app) {
 
    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();
	
	 $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
});

 
$app->router->handle();
$app->theme->render();