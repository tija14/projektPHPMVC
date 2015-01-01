<?php

namespace Anax\Comment;


/**
 * To attach comments-flow to a page or some content.
 *
 */
class ViewController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
	\Anax\MVC\TRedirectHelpers;

	public $comments;
	public $comment;
	public $subcomments;
	

	
	public function initialize() 
    { 
	
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
    public function viewAction() //$pageId
    {
		
		
		$all = $this->comments->findQuestions();
		$mostActiveUsers = $this->comments->getMostActiveUsers();
		$mostPopularTags = $this->comments->getMostPopularTags();
		

        $this->views->add('comment/comments', [
            'comments' => $all,
			'mostActiveUsers' => $mostActiveUsers,
			'mostPopularTags' => $mostPopularTags,
			
        ]);
		
    }
	public function viewCommentAction($commentId) //, $userId
    {
		
		
		$comments = $this->comments->getComment($commentId);
		$answers = $this->comments->getAnswers($commentId); 
		$com = $this->comments->getSubcomments($commentId);
		$coa = $this->comments->getCommentOnAnswer($commentId);
		
		//$commentAnswer = $this->subcomments->getCommentAnswer($commentId);
		//$all = $this->comments->findAll();
		
		//$id = $this->session->get('userId');
		//$id = $this->comments->find($id);
		$this->di->theme->setTitle("Comments"); 
        $this->views->add('comment/page', [
			'questions' => $comments,
			'answers' => $answers,
            'comments' => $com,
			'id' => $commentId,
			'commentsAnswer' => $coa,
			
			
        ]);
		}	
	public function viewQuestionsAction(){
	
	$all = $this->comments->findAllQuestions();
	$this->views->add('comment/comments', [
            'comments' => $all,
			'mostActiveUsers' => null,
			'mostPopularTags' => null,
			
        ]);
	}
	
	/*public function viewCommentAction($id, $user)
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
        ]); 
		
	
		
    }
*/
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

	
	public function viewTagsAction($tag){
	
		//$pageId = $this->comments->getPage($pageId);
		$all = $this->comments->getQuestionsByTags($tag);
		
		$this->di->theme->setTitle("Comments"); 
        $this->views->add('comment/comments', [
			
            'comments' => $all,
			'mostPopularTags' => null,
			'mostActiveUsers' => null,
			//'pageId' => $pageId,
        ]);
	
	}
	
		
	public function tagAction(){
		
		$tags = $this->comments->getTags();
		
		$this->views->add('comment/tags', [
		//'id'        => null, 
        //'pageId'    => 'tags', 
		'tags' => $tags
    ]);
	}
	
	
	
}