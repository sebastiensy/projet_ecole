<?php

require_once('../inc.php');
?>
<?php
session_start();
if(!isset($_SESSION['login']))
{
/*
         si l admine n est pas connecté 
		 on fait une redirection
*/
header('location:index.php?page=con_oper');
}

if(isset($_GET['supprimer']))
{

/*
        suprimer un message particulier
*/
$bd =  $bd = new DB_connection();
$req1="DELETE FROM message WHERE id_msg='".$_GET['id_msg']."' ";
$bd->execRequete($req1);
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


