<div class='users'>

<?php if (is_array($mostActiveUsers)) : ?>
<h2>Mest aktiva användare</h2>
<?php foreach ($mostActiveUsers as $id => $mau) : ?>
<div id ="name"><?=$mau->acronym?></div><br/>
<?php endforeach; ?>


<?php endif; ?>



<?php if (is_array($mostPopularTags)) : ?>
<h2>Populäraste taggarna</h2>
<?php foreach ($mostPopularTags as $id => $mpt) : ?>
<div id="name"><?=$mpt->tag?></div><br/>
<?php endforeach; ?>



<?php endif; ?>


</div>
<hr>
<div id="question"><a href="<?= $this->url->create('comment/form') ?>">Ställ en fråga</a></div>
<h2>Senast ställda frågor</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<table>

<td><h4> <a href="<?= $this->url->create('view/viewComment'.'/'.$comment->id .'/'. $comment->user_id) ?>"><?=$comment->title?></a></h4></td>


<tr>

<td><h5><img src="http://www.gravatar.com/avatar/<?=md5($comment->email);?>.jpg?s=35"></td>
<td><div id="name"><b><?=$comment->name?></b></div></td>
<td><div id ="time"><i> <?=$comment->created?></i></div><td>

<div id ="tag"><?=$comment->tag?></div>
</table>
<hr>
</tr>



<?php endforeach; ?>
</div>


<?php endif; ?>





