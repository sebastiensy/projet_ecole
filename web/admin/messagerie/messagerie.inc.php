<?php

require_once('../inc.php');
require_once('affichage_element.php');

?>
<?php
session_start();
if(!isset($_SESSION['login']))
{
/*
         si l admine n est pas connecté 
		 on fait une redirection
*/
//header('location:index.php?page=con_oper');
}

if(isset($_GET['supprimer']))
{

/*
        suprimer un message particulier
*/
$db = new DB_connection();
$req1="DELETE FROM Message WHERE id_message='".$_GET['id_msg']."' ";
//$db->execRequete($req1);
$db->DB_query($req1);  
  unset( $_SESSION['suprimer'] );
}
if($_GET['afficher'])
{

/*
        affichage du message particulier

*/
 unset( $_SESSION['afficher'] );
}
else{

/*
         si ya pas de message a afficher
		 on affiche la liste de tts les messages
*/
affichage();
}

  ?>


