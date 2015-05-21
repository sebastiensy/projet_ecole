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

$id=$_GET['id'];
$db = new DB_connection();

$req="delete from compose where id_nivliste='".$id."'";

$db->DB_query($req);

$req="delete from inclus where id_nivliste='".$id."'";
$db->DB_query($req);

$req="delete from liste_niveau where id_nivliste='".$id."'";
$db->DB_query($req);
$url="gestion_listes.php";

header("Refresh:0;url=$url");

?>