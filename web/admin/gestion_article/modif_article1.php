<?php

session_start();
require_once('../inc/data.inc.php');

?>

<?php
if(!isset($_SESSION['droits']))
{
	header("Location: ../../index.php");
}
else
{
	if($_SESSION['droits'] != 1)
	{
		header("Location: ../../index.php");
	}
}
?>

<?php

$ref = $_GET['ref'];
$db = new DB_connection();
$db1 = new DB_connection();
/*                                       Modification du Descriptif                                                    */
if($_GET['p']=="modif_desc")
{
	$req="update Materiel set desc_mat='".$_POST['desc']."' where ref_mat='".$ref."'";
	$db->DB_query($req);
}
/*                                      Modification du prix d'une liste 										   */
if($_GET['p']=="modif_prix")
{
	$id=$_GET['id'];
	$dif=$_GET['prix']- $_POST['pr'];
	$req="select * from Compose where id_mat=".$id;
	$db->DB_query($req);

	while($ligne=$db->DB_object())
	{
		$req1="select forfait from Liste_niveau where id_nivliste=".$ligne->id_nivliste;
		$db1->DB_query($req1);
		$ligne1=$db1->DB_object();
		$for=$ligne1->forfait;
		$cha=$ligne->qte_scat*$dif;
		$for=$for - $cha;
		$req1="update Liste_niveau set forfait='".$for."' where id_nivliste=".$ligne->id_nivliste;
		$db1->DB_query($req1);
	}
	$req1="update Materiel set prix_mat='".$_POST['pr']."' where ref_mat='".$ref."'";
	$db1->DB_query($req1);
}
if($_GET['p']=="delete")
{
	$id=$_GET['id'];
	$req="select * from Compose where id_mat=".$id;
	$db->DB_query($req);
	while($ligne=$db->DB_object())
	{
		$req1="select forfait from Liste_niveau where id_nivliste=".$ligne->id_nivliste;
		$db1->DB_query($req1);
		$ligne1=$db1->DB_object();
		$for=$ligne1->forfait;
		$for=$for - ($_GET['prix'] * $ligne->qte_scat);
		$req1="update Liste_niveau set forfait='".$for."' where id_nivliste=".$ligne->id_nivliste;
		$db1->DB_query($req1);
		$req="delete from Compose where id_mat='".$id."'";
	}
	$db->DB_query($req);
	$req="delete from Materiel where ref_mat='".$ref."'";
	$db->DB_query($req);
}
$url="modif_article.php";

?>

<?php

header("Refresh:0;url=$url");

?>