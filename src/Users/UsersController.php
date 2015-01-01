<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
	\Anax\MVC\TRedirectHelpers; 
	  
	public $users; 
	//public $session;
	public $comments;
  

    /** 
     * Initialize the controller. 
     * 
     * @return void 
     */ 
public function initialize() 
    { 
	if(!$this->session->get('userId')){ 
		header("Location: ../login/login");
	}
	
		$this->session = new \Anax\Session\CSession();
        $this->users = new \Anax\Users\User(); 
        $this->users->setDI($this->di); 
		
		 $this->comments = new \Phpmvc\Comment\Comment(); 
        $this->comments->setDI($this->di); 
	
	
    } 

/**
 * List all users.
 *
 * @return void
 */
public function listAction()
{
    $this->users = new \Anax\Users\User();
    $this->users->setDI($this->di);
 
    $all = $this->users->getUsersLatestLogin();
 
    $this->theme->setTitle("List all users");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "View all users",
    ]);
}	

/**
 * List user with id.
 *
 * @param int $id of user to display
 *
 * @return void
 */
public function idAction($id = null)
{
    $this->users = new \Anax\Users\User();
    $this->users->setDI($this->di);
 
    $user = $this->users->find($id);
 
    $this->theme->setTitle("View user with id");
    $this->views->add('users/view', [
        'user' => $user,
    ]);
}
/*

/**
 * Add new user.
 *
 * @param string $acronym of user to add.
 *
 * @return void
 */

public function updateAction($id)
{
	if (!isset($id)) { 
            die("Missing id"); 
        } 
		
		$user = $this->users->find($id); 
		
		$form = new \Anax\HTMLForm\CFormUser($this->users, $user); 
        $form->setDI($this->di); 
        $form->check(); 
		
		$questions = $this->comments->getUserComments($id);
		$answers = $this->comments->getUserSubcomments($id);
         
        $this->di->theme->setTitle("Update user"); 
        $this->di->views->add('default/page', [ 
            'title' => "Update user",  
            'content' => $form->getHTML(),
			
			'questions' => $questions,
			'answers' => $answers,
			'pageId' => "users/profile/". $id,
			'user' => $user,
			
        ]); 
}
/**
 * Delete user.
 *
 * @param integer $id of user to delete.
 *
 * @return void
 */
public function deleteAction($id = null)
{
    if (!isset($id)) {
        die("Missing id");
    }
 
    $res = $this->users->delete($id);
 
    $url = $this->url->create('users/list');
    $this->response->redirect($url);
}

/**
 * Delete (soft) user.
 *
 * @param integer $id of user to delete.
 *
 * @return void
 */
public function softDeleteAction($id = null)
{
    if (!isset($id)) {
        die("Missing id");
    }
 
    $now = gmdate('Y-m-d H:i:s');
 
    $user = $this->users->find($id);
 
    $user->deleted = $now;
    $user->save();
 
    $url = $this->url->create('users/id/' . $id);
    $this->response->redirect($url);
}

/**
 * List all active and not deleted users.
 *
 * @return void
 */
public function activeAction()
{
    $all = $this->users->query()
        ->where('active IS NOT NULL')
        ->andWhere('deleted is NULL')
        ->execute();
 
    $this->theme->setTitle("Users that are active");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Users that are active",
    ]);
}

public function inactiveAction()
{
    $all = $this->users->query()
        ->where('active IS NULL')
        ->andWhere('deleted is NULL')
        ->execute();
 
    $this->theme->setTitle("Users that are inactive");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Users that are inactive",
    ]);
}


public function deactivateAction($id = null)
{
    if (!isset($id)) {
        die("Missing id");
    }
 
    $now = gmdate('Y-m-d H:i:s');
 
    $user = $this->users->find($id);
 
    $user->active = null ;
    $user->save();
	
	$url = $this->url->create('users/id/' . $id);
    $this->response->redirect($url);
}

public function activateAction($id = null)
{
    if (!isset($id)) {
        die("Missing id");
    }
 
    $now = gmdate('Y-m-d H:i:s');
 
    $user = $this->users->find($id);
 
    $user->active = $now;
    $user->save();
	
	$url = $this->url->create('users/id/' . $id);
    $this->response->redirect($url);
}


public function wastebinAction(){
	
	$all = $this->users->query()
        ->where('deleted IS NOT NULL')
		->execute();
	
	
    $this->theme->setTitle("Users that are soft-deleted");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Users that are soft-deleted",
    ]);
}

public function undosoftdeleteAction($id = null){
	
	if (!isset($id)) {
        die("Missing id");
    }
 
    $now = gmdate('Y-m-d H:i:s');
 
    $user = $this->users->find($id);
	 
	$user->deleted = null; 
    $user->save(); 
	
    $url = $this->url->create('users/id/' . $id);
    $this->response->redirect($url);
    
}



 public function profileAction($id){
	
	
	if (!isset($id)) { 
            die("Missing id"); 
        } 
	
		
		$user = $this->users->find($id); 
		
		if($id == $this->session->get('userId')){
		
		
		
		$form = new \Anax\HTMLForm\CFormUser($this->users, $user);
        $form->setDI($this->di); 
        $form->check();
		
	$questions = $this->comments->getUserComments($id);
	$answers = $this->comments->getUserSubcomments($id);
	$comments = $this->comments->getUserCommentz($id);
		
		
	 $this->di->theme->setTitle("Profil"); 
     $this->di->views->add('users/profile', [ 
            'title' => "Profile",  
			'user' => $user,
            'content' => $form->getHTML(),
			'questions' => $questions,
			'answers' => $answers,
			'comments' => $comments,
			'pageId' => "users/profile/". $id,
			
			
        ]); 
 
 }
 else{
header("Location: ../login/login");


 }
 }
 
 /*public function removeAction($id)
    {
		if (!isset($id)) {
			die("Missing id");
		}
		$this->comments->deleteParent($id);
		$this->comments->delete($id);
		
		$this->response->redirect($this->request->getPost('redirect'));
    }
 */
 
}

