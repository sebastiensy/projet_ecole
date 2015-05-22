<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<?php

//$id=$_POST['id'];
$id=$_POST['idListe'];
//$ref=$_POST['ref'];
$idMat=$_POST['idMat'];
$qte=$_POST['qte'];
$db = new DB_connection();

//if($ref!="" and $qte!="")
if($idMat!="" and $qte!="")
{
	//$req="insert into Compose values('".$qte."','".$ref."','".$id."')";
	$req="insert into Compose values('".$qte."','".$idMat."','".$id."')";
	$db->DB_query($req);
	$req="select forfait from Liste_niveau where id_nivListe=".$id;
	$db->DB_query($req);
	if($ligne=$db->DB_object())
	{
		$for=$ligne->forfait;
	}
	//$req="select prix_mat from Materiel where ref_mat='".$ref."'";
	$req="select prix_mat from Materiel where id_mat='".$idMat."'";
	$db->DB_query($req);
	if($ligne=$db->DB_object())
	{
		$prix=$ligne->prix_mat;
		$prix=$prix*$qte;
	}
	$for=$for+$prix;
	$req="update Liste_niveau set forfait=".$for."where id_nivliste=".$id;
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