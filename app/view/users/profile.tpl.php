<form method=post>
		<input type=hidden name="redirect" value="<?=$this->url->create($pageId)?>">
		<input type=hidden name="pageId" value="<?=$pageId?>">
<h1><?=$user->acronym?>s profil:</h1> 
    <table style='width: 100%; text-align: left;'> 
	

    <tr> 
        <th>Id</th> 
		<th>Användarnamn</th>
        <th>Namn</th> 
		
		</tr> <tr> 
        <td><?=$user->id?></td> 
        <td><?=$user->acronym?></td> 
        <td><?=$user->name?></td> 
		<tr/><tr>
		
		
        <th>E-post</th> 
        <th>Medlem sedan</th> 
        <th>Aktiv</th> 
         
    </tr>  

   
        <td><?=$user->email?></td> 
        <td><?=$user->created?></td> 
        <td><?=isset($user->active) ? 'Ja' : 'Nej'?></td> 
        
		
	
    </tr>  
<a href='<?=$this->url->create('users/update').'/' . $user->id ?>'>Updatera</a>
	</table> 

<h4>Frågor:</h4>
<?php if(is_array($questions)) : ?>
<?php foreach($questions as $q) : ?>
<div id="question"><a href="<?= $this->url->create('view/viewComment'.'/'.$q->id .'/'. $q->user_id) ?>"><?=$q->title?></a></div><br/>
<br/>
<a href='<?=$this->url->create('comment/remove/' . $q->id) ?>'>Ta bort</a>

<?php endforeach; ?>
<?php endif; ?>

<h4>Kommentarer:</h4>
<?php if(is_array($comments)) : ?>
<?php foreach($comments as $id => $c) : ?>
<a href="<?= $this->url->create('view/viewComment'.'/'.$c->comment_id .'/'. $c->user_id) ?>"><?=$id +1 . $c->content ?></a>
Kommentar till <a href="<?= $this->url->create('view/viewComment'.'/'.$c->comment_id .'/'. $c->user_id) ?>">denna fråga</a><br/>
<?php endforeach; ?>
<?php endif; ?>

<h4>Svar:</h4>
<?php if(is_array($answers)) : ?>
<?php foreach($answers as $id => $a) : ?>
<a href="<?= $this->url->create('view/viewComment'.'/'.$a->comment_id .'/'. $a->user_id) ?>"><?=$id +1 . " " . $a->content ?></a>
Svar till <a href="<?= $this->url->create('view/viewComment'.'/'.$c->comment_id .'/'. $c->user_id) ?>">denna fråga</a><br/>
<?php endforeach; ?>
<?php endif; ?>

