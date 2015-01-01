<?php

namespace Anax\HTMLForm; 


class CFormSubcomment extends \Mos\HTMLForm\CForm 
{ 
    use \Anax\DI\TInjectionaware, 
    \Anax\MVC\TRedirectHelpers; 
     
    public $id=null;  
	public $users=null;
	public $comment = null;
	public $type= null;
	public $questionId = null;
	//public $userId = null;
     
     
    /** 
     * Constructor 
     * 
     */ 
    public function __construct($comments, $users, $id, $type=null)  //, $questionId
    { 
		$this->id = $id;
		$this->users = $users;
		$this->comments = $comments;
		$this->type = $type;
		//$this->questionId = $questionId;
		
		
		
         
        parent::__construct([], [ 
		 /*'title' => [ 
                'type'        => 'text', 
                'label'       => 'Titel:', 
                //'required'    => true, 
               // 'validation'  => ['not_empty', 'email_adress'], 
                'value'          => isset($comment) ? $comment->title : '', 
            ], */
            'content' => [ 
                'type'        => 'textarea', 
                'label'       => 'Kommentar:', 
                //'required'    => true, 
                //'validation'  => ['not_empty'], 
                'value'          => isset($comment) ? $comment->content : '', 
            ], 
           /* 'email' => [ 
                'type'        => 'hidden', 
                'label'       => 'E-post:', 
                //'required'    => true, 
               // 'validation'  => ['not_empty', 'email_adress'], 
                'value'          => isset($comment) ? $comment->email : '', 
            ], 
            'name' => [ 
                'type'        => 'hidden', 
                'label'       => 'Namn:', 
                //'required'    => true, 
                //'validation'  => ['not_empty'], 
                'value'          => isset($comment) ? $comment->name : '', 
            ], 
            'homepage' => [ 
                'type'        => 'hidden', 
                'label'       => 'Webbplats:', 
                //'required'    => true, 
                //'validation'  => ['not_empty'], 
                'value'          => '', 
            ], */
            'submit' => [ 
                'type'      => 'submit', 
                'callback'  => [$this, 'callbackSubmit'], 
            ], 
			'reset' => [ 
                'type'      => 'reset', 
                'value'        => 'Reset' 
            ], 
        ]); 
    } 
     
    /** 
    * Customise the check() method. 
    * 
    * @param callable $callIfSuccess handler to call if function returns true. 
    * @param callable $callIfFail handler to call if function returns true. 
    */ 
    public function check($callIfSuccess = null, $callIfFail = null) 
    { 
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']); 
    } 
     
     
    /** 
    * Callback for submit-button. 
    * 
    */ 
    public function callbackSubmit() 
    { 
	$this->saveInSession = true;
        $now = gmdate('Y-m-d H:i:s'); 
        //$acr = $this->di->session->get('userId');
		//$user = $this->users->findAcronym($acr);
		$content = $this->Value('content');
		$created = $now;
		
		//$acr = $this->di->session->get('userId');
		//$uzer = $this->users->findAcronym($acr);
		$id = $_SESSION['userId'];
		$uzer = $this->users->find($id);
		$user = $uzer->id;
		
		$username = $uzer->acronym;
		$id = $this->id;
		$this->saveInSession = true; 
		
		if($this->type == "answer"){
        $this->comments->addSubcomment($id, $user, $content, $created, $this->type);
		$this->redirectTo('view/viewComment/'. $id .'/'. $user); 
		}
		if($this->type == "comment"){
        $this->comments->addSubcomment($id, $user, $content, $created, $this->type);
		}
		else {
		
		$this->comments->addSubcommentAnswer($id, $user, $content, $created, $username);
		$this->redirectTo('view/viewComment/'. $this->questionId .'/'. $user); 
		
		}
		
       
		$this->redirectTo('view/viewComment/'. $id .'/'. $user); 
        return true; 
    } 
	
	 public function callbackUpdate() 
    { 
        $now = gmdate('Y-m-d H:i:s'); 
         
        $this->comments->save([ 
            'email' => $this->Value('email'), 
            'name' => $this->Value('name'), 
            'homepage' => $this->Value('homepage'), 
            'pageId' => $this->pageId, 
            'comment' => $this->Value('comment'), 
            //'created' => $now,
        ]); 
         
        $this->saveInSession = true; 
		
        return true; 
    } 
     
     
    /** 
     * Callback What to do if the form was submitted? 
     * 
     */ 
    public function callbackSuccess() 
    { 
        
        $this->redirectTo('questions'); 
    } 
     
     
    /** 
     * Callback What to do when form could not be processed? 
     * 
     */ 
    public function callbackFail() 
    { 
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>"); 
        $this->redirectTo(); 
    } 
} 