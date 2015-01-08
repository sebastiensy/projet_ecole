<?php 
        /*
		   s occupe de la mise en forme d une ligne du formulaire
		
		*/
		function mise_en_forme($idlist,$niv,$prix){

?>

 <tr>
       <td><a href="?id=<?php echo $idlist;?>"> <?php echo $niv;?></a></td>
       <td><?php echo $prix;?></td>
       <td><input type="text" class="spinner" size="2" min="1" max="20" name="<?php echo $idlist;?>" /></td>
   </tr>
 

<?php

}

/*

      s occupe de la mise en forme de l en tete du formulaire
*/
function head(){

?>
<form method="POST" action="liste.php">
<table id="liste">
  <tr>
       <th>Niveau</th>
       <th>Prix forfaitaire</th>
       <th>Quantit&eacute;</th>
   </tr>
<?php 

}
?>

<?php 

   /*
           mise en forme du footer du formulaire
   
   */

 function footer(){?>

    <tr>
       <td colspan="2"></td>
       <td><input type="submit" class="" name="envoyer" value="envoyer"></td>
   </tr>
   </table>
   </form>
<?php }?>


<?php
   /*
           affichage des listes
                
   */



 function affichage(){
     
	 
	 /*
	      placement de l entete
	 
	 */
      
          head();
	 
	 /*
			perparation de la requete 
			*/
			$requete = 'select * from liste_niveau';

			/*
			connexion a la base via la classe DB_connection
			*/
			$db = new DB_connection();

			/*
			exécution de la requete 
			*/
			$db->DB_query($requete);

			/*
			   mise en forme
			*/	 
			

	 while(($ligne = $db->DB_object())!=null){
	 
	       mise_en_forme($ligne->id_nivliste,$ligne->niveau,$ligne->forfait);
	 }
	 
	 footer();
	 

}?>