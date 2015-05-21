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

$req="DELETE from Message where id_message='".$id."'";

$db->DB_query($req);
	
$url="messagerie.php";
header("Refresh:0;url=$url");

?>