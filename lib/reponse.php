<?php 
session_start();

require_once('lib_workflow.php');

if($_GET["reponse"] == 1)
{
	echo affiche_workflow();
}
else if($_GET["reponse"] == 2)
{
	echo "Lu";
}

?>