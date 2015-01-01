<div id="question">
<?php foreach($tags as $tag) : ?>

<a href="<?=$this->url->create('view/viewTags/' . $tag->tag) ?>"><?=$tag->tag?></a><br/><br/>

<?php endforeach; ?>
</div>