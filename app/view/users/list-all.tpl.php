   <table> 
   <tr>
   <th><h1>Senast inloggade</h1></th>
    <tr> 
       <th>Användarnamn</th> 
          <th>Email</th> 
		  <th>Senast inloggad</th>
		 
 
 
<?php foreach ($users as $user) : ?>
 <tr>

<td><?=$user->acronym?></td>  
<td><?=$user->email?></td>
<td><?=$user->active?></td>


</tr>

<?php endforeach; ?>




</table>
