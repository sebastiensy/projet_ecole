<?php
	require_once('../inc.php');
	$id=$_GET['id'];
	$db = new DB_connection();
	
	$req="DELETE from Message where id_message='".$id."'";
	
	$db->DB_query($req);
		
	$url="messagerie.php";
	header("Refresh:0;url=$url");
?>