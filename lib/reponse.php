<?php 
session_start();

require_once('../data/config.php');
require_once('lib_db.class.php');
require_once('lib_workflow.php');


if($_GET["reponse"] == 1)
{
	echo affiche_workflow();
}

?>