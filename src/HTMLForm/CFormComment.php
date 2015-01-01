<?php

namespace Anax\HTMLForm; 


class CFormComment extends \Mos\HTMLForm\CForm 
{ 
    use \Anax\DI\TInjectionaware, 
    \Anax\MVC\TRedirectHelpers; 
     
    public $comments=null;  
	public $pageId= null;
	public $comment = null;
     
     
    /** 
     * Constructor 
     * 
     */ 
    public function __construct($comments, $pageId, $comment = null, $id= null) 
    { 
        
         
        $this->comments=$comments; 
		$this->comment= $comment; 
        $this->pageId = $pageId;
         
        parent::__construct([], [ 
		 'title' => [ 
                'type'        => 'text', 
                'label'       => 'Titel:', 
                //'required'    => true, 
               // 'validation'  => ['not_empty', 'email_adress'], 
                'value'          => isset($comment) ? $comment->title : '', 
            ], 
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
       // $now = gmdate('Y-m-d H:i:s'); 
         
        /*$this->comments->save([ 
            'email' => $this->Value('email'), 
            'name' => $this->Value('name'), 
            'homepage' => $this->Value('homepage'), 
            'pageId' => $this->pageId, 
            'content' => $this->Value('content'), 
            'created' => $now,
        ]); */
         
        $this->saveInSession = true; 
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
        
        $this->redirectTo(); 
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