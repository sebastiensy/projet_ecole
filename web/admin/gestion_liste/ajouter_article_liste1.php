<?php
	require_once('../inc.php');
	$id=$_POST['id'];
	$ref=$_POST['ref'];
	$qte=$_POST['qte'];
	$db = new DB_connection();
	
	if($ref!="" and $qte!="")
	{
		$req="insert into compose values('".$qte."','".$ref."','".$id."')";
		$db->DB_query($req);
		$req="select forfait from liste_niveau where id_nivListe=".$id;
		$db->DB_query($req);
		if($ligne=$db->DB_object())
		{
			$for=$ligne->forfait;
		}
		$req="select prix_mat from materiel where ref_mat='".$ref."'";
		$db->DB_query($req);
		if($ligne=$db->DB_object())
		{
			$prix=$ligne->prix_mat;
			$prix=$prix*$qte;
		}
		$for=$for+$prix;
		$req="update liste_niveau set forfait=".$for."where id_nivliste=".$id;
		$db->DB_query($req);
	}
	
	$url="modif_liste.php?id=".$id;
	
 ?>

<script type="text/javascript">
	window.parent.jQuery.fancybox.close();
</script>
<?php 
header("Refresh:0;url=$url");	
?>