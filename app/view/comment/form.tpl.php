<div class='comment-form'>
    <form method=post>
		<input type=hidden name="redirect" value="<?=$this->url->create($pageId)?>">
		<input type=hidden name="pageId" value="<?=$pageId?>">
		<?php $id = $this->session->get('userId'); ?>
		
		<fieldset>
        <legend>Ställ en fråga</legend>
		<p><label>Titel:<br/><input type='text' name='title' value='<?=$title?>'/></label></p>
        <p><label>Fråga:<br/><textarea name='content'><?=$content?></textarea></label></p>
		<p><label>Tag:<br/><input type='text' name='tag'></label></p>
        <p>Att välja mellan: Resmål, Aktiviteter, Historia, Allmänt </p>
        <p class=buttons>
		
		
            <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/add').'/' . $pageId .'/'. $id?>'"/>
            <input type='reset' value='Reset'/>
        </p>
        
        </fieldset>
    </form>
</div>
