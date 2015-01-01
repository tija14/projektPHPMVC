<?php

namespace Anax\Comment;


/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
	\Anax\MVC\TRedirectHelpers;

	public $comments;
	public $comment;
	public $subcomments;
	

	
	public function initialize() 
    { 
		if(!$this->session->get('userId')){
		header("Location: ../login/login");
		}
	
        $this->comments = new \Phpmvc\Comment\Comment(); 
        $this->comments->setDI($this->di); 
		
		$this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
		
    } 
    /**
     * View all comments.
     *
     * @return void
     */
   
	public function viewCommentAction($id, $user)
    {
		
		
		$all = $this->comments->getComment($id);
		//$all = $this->comments->findAll();
		
		//$id = $this->session->get('userId');
		//$id = $this->comments->find($id);
		$this->di->theme->setTitle("Comments"); 
        $this->views->add('comment/page', [
			
            'comments' => $all,
			'id' => $id,
        ]);
		
		/*$form = new \Anax\HTMLForm\CFormSubcomment($this->comments, $this->users, $id, $userId);
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Kommentera"); 
        $this->di->views->add('default/page', [ 
            'title' => "Kommentera",  
			
            'content' => $form->getHTML() 
        ]); */
		
	
		
    }

	/*public function viewCommentByUserAction($id)
    {
		
		
		$all = $this->comments->getCommentByUser($id, $userId);
		//$all = $this->comments->findAll();
		
		//$id = $this->session->get('userId');
		//$id = $this->comments->find($id);
		 $this->di->theme->setTitle("Comments"); 
        $this->views->add('comment/page', [
			
            'comments' => $all,
			'id' => $id,
        ]);
		
    }*/

	
	
	/**
 * Add a comment.
 *
 * @return void
 */
	public function addAction($pageId, $params= null)
	{
	
		$now = gmdate('Y-m-d H:i:s'); 
		$isPosted = $this->request->getPost('doCreate');
		
		//$user = $this->comments->find($id);
	
		if (!$isPosted) {
			$this->response->redirect($this->request->getPost('redirect'));
		}
		$id = $this->di->session->get('userId');
		$user = $this->users->find($id);
		
		//$user = $this->findAcronym($this->session->get('userId'););
		$comment = [
			'title'   => $this->request->getPost('title'),
			'content'   => $this->request->getPost('content'),
			'name'      => $user->acronym,
			//'homepage'       => $this->request->getPost('web'),
			'email'      => $user->email,
			
			'created' => $now,
			'user_id' => $user->id,
			'tag' => $this->request->getPost('tag'),
            //'pageId'       => $pageId,
			
		];
		//$commentId = $this->comments->db->lastInsertId();
		$tag = $this->request->getPost('tag');
		//$tag = $this->comments->getTagId($tagz);
		 //$commentId, 
		
          
		$this->comments->save($comment); 
		$commentId = $this->comments->db->lastInsertId();
		$this->comments->saveTags($commentId, $tag);

        $this->response->redirect($this->request->getPost('redirect'));
	}

	
	public function removeAction($id)
    {
		if (!isset($id)) {
			die("Missing id");
		}
		
		
		$this->comments->deleteParent($id);
		$this->comments->deleteComments($id);
		$this->comments->delete($id);
		
 
		$this->response->redirect($this->request->getPost('redirect'));
    }
	
	public function editAction($id, $pageId){
	
		$comment = $this->comments->find($id); 
		if (!isset($id)) { 
            die("Missing id"); 
        } 
		
		$form = new \Anax\HTMLForm\CFormComment($this->comments, $pageId, $comment, $id); 
        
		$form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Update user"); 
        $this->di->views->add('default/page', [ 
            'title' => "Update comment" . " " .$id, 
            'content' => $form->getHTML() 
        ]); 
	
        
	
	}
	
	public function saveAction($id)
	{
		
		$isPosted = $this->request->getPost('doCreate');
	 
		if (!$isPosted) {
			$this->response->redirect($this->request->getPost('redirect'));
		}
		//$comment = $this->comments->find($id);
		
		$comment = [
			'content'   => $this->request->getPost('content'),
			'name'      => $this->request->getPost('name'),
			'homepage'  => $this->request->getPost('web'),
			'email'      => $this->request->getPost('mail'),
			'id' => 	$id,
            
			
		];
          
		$this->comments->save($comment); //eller create?
		$tags = $this->request->getPost('tag');
		$this->comments->saveTags(); //$tags

        $this->response->redirect($this->request->getPost('redirect'));
	}
	
	public function tagAction(){
		
		$tags = $this->comments->getTags();
		
		$this->views->add('comment/tags', [
		//'id'        => null, 
        //'pageId'    => 'tags', 
		'tags' => $tags
    ]);
	
	
	}
	
	public function formAction(){
	
	$this->di->theme->setTitle("Ask a question"); 
    $this->views->add('comment/form', [
		'title' => null,
        //'mail'      => null,
        //'web'       => null,
        //'name'      => null,
        'content'   => null,
        'output'    => null,
		'id'        => null, 
        'pageId'    => 'questions', 
    ]);
	
	
	
	}
}
