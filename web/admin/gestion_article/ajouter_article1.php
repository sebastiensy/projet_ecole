<?php
	require_once('../inc/data.inc.php');
	
	function verif() {
	if (isset($_POST['ref']) && isset($_POST['desc']) && isset($_POST['prix']))
	{
		$db = new DB_connection();
	
		$req = "SELECT ref_mat FROM Materiel WHERE ref_mat = ".$_POST['ref'];
		$db->DB_query($req);
		

		if($ligne=$db->DB_object())
		{
			echo "<span style=\"color:red\"><p><strong>Le produit ayant pour reference ".$_POST['ref']." existe deja. Veuillez modifier la reference !</strong></p></span>";
		}
		else
		{
			$req1="insert into Sous_categorie values('','".$_POST['categorie']."','')";
			$db->DB_query($req1);
			$id=$db->DB_id();

			$req1="insert into Materiel (ref_mat, desc_mat, prix_mat, id_scat) values ('".$_POST['ref']."','".$_POST['desc']."','".$_POST['prix']."','".$id."')";
			$db->DB_query($req1);

			//$url = "ajouter_article.php";
			//header("Refresh:0;url=$url");
			echo "<span style=\"color:green\"><p><strong>Le produit ayant pour reference ".$_POST['ref']." a bien été ajouté.</strong></p></span>";
		}
	}
	}					
?>

