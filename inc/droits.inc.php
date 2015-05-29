<?php
if(!isset($_SESSION["id_parent"]))
{
	header("Location: ../index.php");
	exit;
}
?>