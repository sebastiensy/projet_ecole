<?php  

     function affichage_element($res){
	 
	 /*
	     affiche une ligne du resulta de la table message
		 qui est contenue dans le tableau associatif $res
		 qui represente une une du du table en html
	 */
echo '

<tr>
<td class="Style3">'.$res['id_msg'].'</td>
<td class="Style3">'.$res['email_client'].'</td>
<td class="Style3">'.$res['objet_msg'].'</td>
<td class="Style3">'.$res['date_msg'].'</td>
<td class="Style3">'.$res['heure_msg'].'</td>
<td class="Style3">'.$res['etat'].'</td>
<td><a class="Style2" href="messagerie.php?id_msg= '.$res['id_msg'].'&supprimer=ok" >SUPPRIMER</a></td>
<td><a class="Style2" href="messagerie.php?id_msg= '.$res['id_msg'].'&afficher=ok" >AFFICHER</a></td>
</tr>';

 }
?>
  <?php  function affichage_header(){
	/*
	     initialise l entete du tableau
	
	*/
?>
	
	<tr>
<td class="Style2">Numero message</td>
<td class="Style2">email</td>
<td class="Style2"> objet message</td>
<td class="Style2"> date message</td>
<td class="Style2"> heure message</td>
<td class="Style2"> etat</td>
</tr>
	
	<?php} 
	
	
	function affichage(){
	
	/*
	   la mise page de l affichage des messages
	*/
	$db = new DB_connection();
	$req = "SELECT * FROM Message ORDER BY id_message desc";
	//$bd->execRequete($req);
	$db->DB_query($req);
	
	/*
	   affichage de l entete
	*/
	 affichage_header();
	
	?>
	<table align="center" border="2" width="1000"style="text-align:center;color:#00F;font-size:16px">
	
	<?php 
	       /*
		      construction du tableau qui ce fait ligne par ligne 
			  a l aide de la fonction affichage_element qui prend 
			  en parametre une ligne du resulta de l execution
			  de la requete
		    */
	   while($res=$db->DB_assoc()) {
											//affichage_element($res);
									}
  
  ?>
	
	</table>
	<?php
	}

?>