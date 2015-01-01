<article class="article1">
 
<?php if(isset($content)) :?>
 <?=$content?>
 <?php endif; ?>
 
<?php if(isset($byline)) : ?>
<footer class="byline">
<?=$byline?>
</footer>
<?php endif; ?>
 
</article>