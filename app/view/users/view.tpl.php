<p> 
    <a href="<?=$this->url->create('users/list')?>">Alla användare</a> /
    <a href="<?=$this->url->create('users/active')?>">Aktiva användare</a> / 
    <a href="<?=$this->url->create('users/inactive')?>">Inaktiva användare</a> /
    <a href="<?=$this->url->create('users/wastebin')?>">Papperskorgen</a> /
</p> 

<h1>Användare <?=$user->id?></h1> 
  Session=<?=$this->session->get('userId')?>
    <table style='width: 100%; text-align: left;'> 

    <tr> 
        <th>Id</th> 
        <th>Acronym</th> 
        <th>Namn</th> 
        <th>E-post</th> 
        <th>Skapad</th> 
        <th>Aktiv</th> 
        <th>Borttagen</th> 
    </tr>  

    <tr> 
        <td><?=$user->id?></td> 
        <td><?=$user->acronym?></td> 
        <td><?=$user->name?></td> 
        <td><?=$user->email?></td> 
        <td><?=$user->created?></td> 
        <td><?=isset($user->active) ? 'Ja' : 'Nej'?></td> 
        <td><?=isset($user->deleted) ? 'Ja' : 'Nej'?></td> 
    </tr>  

</table> 


<p><a href="<?=$this->url->create('users/update/' . $user->id) ?>">Uppdatera</a> |  
<?php if(isset($user->active)) : ?> 
<a href="<?=$this->url->create('users/deactivate/' . $user->id) ?>">Avaktivera</a> |  

<?php else :?> 
<a href="<?=$this->url->create('users/activate/' . $user->id) ?>">Aktivera</a> |  
<?php endif; ?> 

<?php if(isset($user->deleted)) :?> 
<a href="<?=$this->url->create('users/undosoftdelete/' . $user->id) ?>">Ångra Soft delete</a> |  
<?php else :?>  
<a href="<?=$this->url->create('users/soft-delete/' . $user->id) ?>">Soft delete</a> |  
<?php endif; ?> 
<a href="<?=$this->url->create('users/delete/' . $user->id) ?>">Ta bort permanent</a></p> 
