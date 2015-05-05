<?php
	require_once('../inc.php');
	
	$db = new DB_connection();
	
	
		$req="insert into sous_categorie values('','".$_POST['categorie']."','')";
		$db->DB_query($req);
		$id=$db->DB_id();
		
		$req="insert into materiel values('".$_POST['ref']."','".$_POST['desc']."','".$_POST['prix']."','".$id."')";
		$db->DB_query($req);
	
	//$url="modif_liste.php?id=".$id;
		$url = "ajouter_article.php";
		header("Refresh:0;url=$url");	
	
 ?>

<script type="text/javascript">
	alert("Votre article a ete ajoute !");
</script>

