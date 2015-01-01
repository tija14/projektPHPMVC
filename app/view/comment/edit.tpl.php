

<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($pageId)?>">
		<input type=hidden name="pageId" value="<?=$pageId?>">
	
		
	
        <fieldset>
        <legend>Edit a comment</legend>
		 <p><label>Titel:<br/><input type='text' name='title' value='<?=$title?>'/></label></p>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
		
		
            <input type='submit' name='doSave' value='Edit' onClick="this.form.action = '<?=$this->url->create('comment/save/' . $comments->id) ?>'"/>
		
            <input type='reset' value='Reset'/>
           
        </p>
        
        </fieldset>
	</form>
	
</div>

