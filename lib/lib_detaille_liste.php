<?php 
               /*
			           affichage du contenu de la liste
			   
			   */
            function affichage_contenue_liste($id){
/*
			perparation de la requete 
			*/
			$requete = 'select Materiel.desc_mat,Materiel.prix_mat,Compose.qte_scat from Compose, Materiel where  Compose.id_nivliste='.$id.' and Compose.ref_mat=Materiel.ref_mat order by asc Materiel.id_scat';

			/*
			connexion a la base via la classe DB_connection
			*/
			$db = new DB_connection();

			/*
			exécution de la requete 
			*/
			$db->DB_query($requete);

			header_liste();
			while($ligne = $db->DB_object())!=null){
			
			affichage_element($ligne->desc_mat,$ligne->qte_scat,$ligne->prix);
			}

			footer_liste();
?>

<?php }

		/* 
		       mise en forme de l entete pour l affichage d une liste
		
		*/
     function header_liste(){
	 ?>
	 <form method="POST" action="">
	 <table>
  
   <tr>
       <th>Description Materiel</th>
       <th>Quantité </th>
       <th>Prix</th>
   </tr>
	 
	 <?php}
					/*
					    mise en forme du footer pour l affichage d une liste
					
					
					*/
               function footer_liste(){
 ?>
 
 
  <tr>
       <td></td>
       <td></td>
       <td><input type="submit" class="" name="ajouter" value="ajouter"></td>
   </tr>
  </table>
  </form>
 <?php }
 
 
               function affichage_element($desc,$qte,$prix){
 ?>
 
     <tr>
       <td><?php echo $desc;?></td>
       <td><?php echo $qte;?></td>
       <td><input type="text" class="" name="<?php echo $idlist;?>" value="<?php echo $prix;?>"></td>
   </tr>
 <?php
 
 }
 ?>