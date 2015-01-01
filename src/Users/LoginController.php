<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class LoginController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
	\Anax\MVC\TRedirectHelpers; 
	  
	public $users; 
	public $session;
  

    /** 
     * Initialize the controller. 
     * 
     * @return void 
     */ 
public function initialize() 
    { 
	
		$this->session = new \Anax\Session\CSession();
        $this->users = new \Anax\Users\User(); 
        $this->users->setDI($this->di); 
    } 


public function loginAction(){
	
		
		$form = new \Anax\HTMLForm\CFormLogin($this->users);
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Login"); 
        $this->di->views->add('default/page', [ 
            'title' => "Login",  
			
            'content' => $form->getHTML() 
        ]); 

	
}



public function logoutAction(){
		
		$this->session->destroy('userId'); 
        $this->response->redirect($this->url->create('questions')); 

	
	}
	
public function addAction($acronym = null)
{
		$form = new \Anax\HTMLForm\CFormUser($this->users); 
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Add user"); 
        $this->di->views->add('default/page', [ 
            'title' => "Add user", 
            'content' => $form->getHTML() 
        ]); 
		
}
public function idAction($id = null)
{
    $this->users = new \Anax\Users\User();
    $this->users->setDI($this->di);
 
    $user = $this->users->find($id);
 
    $this->theme->setTitle("View user with id");
    $this->views->add('users/profile', [
        'user' => $user,
		
    ]);
}
}