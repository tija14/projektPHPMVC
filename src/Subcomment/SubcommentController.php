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
		/*if(!$_SESSION['userId']){
		header("Location: login/login");
		}*/
	
        $this->subcomments = new \Phpmvc\Comment\Subcomment(); 
        $this->subcomments->setDI($this->di); 
		
		$this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    } 
    
	public function viewCommentAction($commentId)
    {
		
		$comments = $this->subcomments->getComment($commentId);
		$sub = $this->subcomments->getSubComment($commentId); 
		//$all = $this->comments->findAll();
		
		//$id = $this->session->get('userId');
		//$id = $this->comments->find($id);
		$this->di->theme->setTitle("Comments"); 
        $this->views->add('comment/page', [
			'comments' => $comments,
            'subcomments' => $sub,
			//'id' => $commentId,
        ]);
		
		$form = new \Anax\HTMLForm\CFormSubcomment($this->subcomments, $this->users, $commentId);
        $form->setDI($this->di); 
        $form->check(); 
         
        $this->di->theme->setTitle("Kommentera"); 
        $this->di->views->add('default/page', [ 
            'title' => "Kommentera",  
			
            'content' => $form->getHTML() 
        ]); 
		
		
}
}
