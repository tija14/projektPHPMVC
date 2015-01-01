<hr>


<?php if (is_array($questions)) : ?>
<div class='comments'>
<?php foreach ($questions as $id => $q) : ?>
<h2><?=$q->title?></h2>
<br/>




<table><tr>
<td><h5><img src="http://www.gravatar.com/avatar/<?=md5($q->email);?>.jpg?s=35"></h5></td>
<p><?=$this->textFilter->doFilter($q->content, 'shortcode, markdown');?>
</p>
<td><div id="name"><?=$q->name ?></div></td><td><?=$q->created?></td>

<td><div id="tag"><p><?=$q->tag?></p></div></td>
</tr>
</table>
</div>

<a href="<?=$this->url->create('subcomment/formAnswer/'. $q->id) ?>">Skriv ett svar </a>
<a href="<?=$this->url->create('subcomment/formComment/'. $q->id)?>"><br/>Skriv en kommentar </a>
<?php endforeach; ?>
<?php endif; ?>

<hr>
<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $c) : ?>

<div class='subcomments'>

<p><?=$this->textFilter->doFilter($c->content, 'shortcode, markdown');?> -
<?=$c->acronym?>&nbsp;
<?=$c->created ?>
</div>
<hr>

<br/>
<?php endforeach; ?>
<br/>

</div>
<i class="fa fa-level-up"></i>
<?php endif; ?>


<?php if (is_array($answers)) : ?>

<?php foreach ($answers as $id => $a) : ?>

<div class='answers'>
<b>Svar nr: <?=$id +1?></b>

<table ><tr>
<td><h5><img src="http://www.gravatar.com/avatar/<?=md5($q->email);?>.jpg?s=35"></h5></td>

<td><div id="name"><?=$a->acronym ?></div></td><td><?=$a->created?></td>
<p><p><?=$this->textFilter->doFilter($a->content, 'shortcode, markdown');?></p>

</tr>
</table>


<a href="<?=$this->url->create('subcomment/formCommentOnAnswer/'. $a->cid .'/'. $a->comment_id) ?>"><br/>Skriv en kommentar </a>
</div>
<hr>

<?php foreach($commentsAnswer as $c ) : ?>

<?php if($a->cid == $c->answer_id) :?>

<div class='subcomments'>
<?=$c->comment?><br/> -
<?=$c->name?>&nbsp;
<?=$c->created ?>
<hr>
</div>
<?php endif; ?>
<?php endforeach; ?>

<?php endforeach; ?>

<br/>
</div>
<?php endif; ?>


