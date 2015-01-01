<?php

namespace Anax\Comment;


/**
 * To attach comments-flow to a page or some content.
 *
 */
class SubcommentController implements \Anax\DI\IInjectionAware //\Anax\Comment\CommentController
{
    use \Anax\DI\TInjectable,
	\Anax\MVC\TRedirectHelpers;

	public $subcomments;
	public $comment;
	

	
	public function initialize() 
    { 
		if(!$this->session->get('userId')){
		header("Location: ../../login/login");
		}
	
        $this->subcomments = new \Phpmvc\Comment\Comment(); 
        $this->subcomments->setDI($this->di); 
		
		$this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    } 
   
	
	public function formAnswerAction($commentId){
	
		$type = "answer";
		$questionId = null;
		
		$form = new \Anax\HTMLForm\CFormSubcomment($this->subcomments, $this->users, $commentId, $type, $questionId );
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Kommentera"); 
        $this->di->views->add('default/page', [ 
            'title' => "Kommentera",  
            'content' => $form->getHTML(),
			
        ]);
	
	}
	
		public function formCommentAction($commentId){
	
		$type = "comment";
		$questionId = null;
		
		$form = new \Anax\HTMLForm\CFormSubcomment($this->subcomments, $this->users, $commentId, $type, $questionId );
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Kommentera"); 
        $this->di->views->add('default/page', [ 
            'title' => "Kommentera",  
			
            'content' => $form->getHTML() 
        ]);
	
	}
	
	public function formCommentOnAnswerAction($commentId, $questionId){
	
		$type = null;
		$form = new \Anax\HTMLForm\CFormSubcomment($this->subcomments, $this->users, $commentId, $type, $questionId);
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Kommentera"); 
        $this->di->views->add('default/page', [ 
            'title' => "Kommentera",  
			
            'content' => $form->getHTML() 
        ]);
	
	}
		
		

}
