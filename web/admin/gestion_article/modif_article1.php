<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<?php

$db = new DB_connection();
$db1 = new DB_connection();
$ref = $db->quote($_GET['ref']);

/*                                       Modification du Descriptif                                                    */
if($_GET['p']=="modif_desc")
{
	$req="update Materiel set desc_mat='".$db->quote($_POST['desc'])."' where ref_mat='".$ref."'";
	$db->DB_query($req);
}
/*                                      Modification du prix d'une liste 										   */
if($_GET['p']=="modif_prix")
{
	$id=$db->quote($_GET['id']);
	$dif=$db->quote($_GET['prix']) - $db->quote($_POST['pr']);
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
	$req1="update Materiel set prix_mat='".$db->quote($_POST['pr'])."' where ref_mat='".$ref."'";
	$db1->DB_query($req1);
}
if($_GET['p']=="delete")
{
	$id=$db->quote($_GET['id']);
	$req="select * from Compose where id_mat=".$id;
	$db->DB_query($req);
	while($ligne=$db->DB_object())
	{
		$req1="select forfait from Liste_niveau where id_nivliste=".$ligne->id_nivliste;
		$db1->DB_query($req1);
		$ligne1=$db1->DB_object();
		$for=$ligne1->forfait;
		$for=$for - ($db->quote($_GET['prix']) * $ligne->qte_scat);
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