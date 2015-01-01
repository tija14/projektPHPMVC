<?php

require __DIR__.'/config_with_app.php'; 

$di  = new \Anax\DI\CDIFactoryDefault(); 

$di->set('form', '\Mos\HTMLForm\CForm'); 

$di->set('CommentController', function() use ($di) { 
    $controller = new \Anax\Comment\CommentController(); 
    $controller->setDI($di); 
    return $controller; 
}); 

$di->set('SubcommentController', function() use ($di) { 
    $controller = new \Anax\Comment\SubcommentController(); 
    $controller->setDI($di); 
    return $controller; 
}); 
$di->set('ViewController', function() use ($di) { 
    $controller = new \Anax\Comment\ViewController(); 
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

$di->set('LoginController', function() use ($di) { 
    $controller = new \Anax\Users\LoginController(); 
    $controller->setDI($di); 
    return $controller; 
}); 
//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app = new \Anax\Kernel\CAnax($di); 


$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$app->session(); 




$app->router->add('home', function() use ($app) {
    $app->theme->setTitle("Hem");

    //$content = $app->fileContent->get('me.md');
   // $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

	$app->dispatcher->forward([
        'controller' => 'view',
        'action'     => 'view',
		'params'     => ['home'], 
    ]);
	

	
});

$app->router->add('questions', function() use ($app) {
    $app->theme->setTitle("questions");

    //$content = $app->fileContent->get('me.md');
   // $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

	$app->dispatcher->forward([
        'controller' => 'view',
        'action'     => 'viewQuestions',
		'params'     => ['questions'], 
    ]);
	

	
});

$app->router->add('tags', function() use ($app) {
    $app->theme->setTitle("Taggar");
	
	
  $app->dispatcher->forward([
        'controller' => 'view',
        'action'     => 'tag',
		//'params'     => [''], 
    ]);

});



$app->router->add('about', function() use ($app) {
    $app->theme->setTitle("Om oss");

    $content = $app->fileContent->get('about.md');
   $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
	
	$app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline
    ]);
	
});



$app->router->add('setup', function() use ($app) {
 
    //$app->db->setVerbose();
 
    /*$app->db->dropTableIfExists('user')->execute();
 
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
	*/
 
});

 
$app->router->handle();
$app->theme->render();