<?php
	require_once('../inc/data.inc.php');
	
	$db = new DB_connection();
	
	
		$req="insert into Sous_categorie values('','".$_POST['categorie']."','')";
		$db->DB_query($req);
		$id=$db->DB_id();

		$req2 = "select * from Materiel";
		$db->DB_query($req2);
		$nb=$db->DB_count();

		$req="insert into Materiel values($nb+1,'".$_POST['ref']."','".$_POST['desc']."','".$_POST['prix']."','".$id."')";
		$db->DB_query($req);
	
	//$url="modif_liste.php?id=".$id;
		$url = "ajouter_article.php";
		header("Refresh:0;url=$url");	
	
 ?>

<script type="text/javascript">
	alert("Votre article a ete ajoute !");
</script>

