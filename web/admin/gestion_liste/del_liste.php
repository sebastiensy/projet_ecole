<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<?php

if(isset($_GET['id']))
{
	$db = new DB_connection();
	$id = $db->quote($_GET['id']);

	$req = "delete from compose where id_nivliste = '".$id."'";

	$db->DB_query($req);

	$req = "delete from inclus where id_nivliste = '".$id."'";
	$db->DB_query($req);

	$req = "delete from liste_niveau where id_nivliste = '".$id."'";
	$db->DB_query($req);

	$db->DB_done();
}
$url = "gestion_listes.php";
header("Refresh:0;url=$url");

?>