<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_liste_affichage.php');

if(!isset($_SESSION['id_parent']))
{
	// si l admin n est pas connecté => redirection
	header('location:../');
}
else
{


if(isset($_POST["envoyer"])){
            /*
				perparation de la requete 
			*/
			$requete = 'select id_nivliste, forfait from Liste_niveau';

			/*
			connexion a la base via la classe DB_connection
			*/
			$db = new DB_connection();

			/*
			exécution de la requete 
			*/
			$db->DB_query($requete);
			
			 while(($ligne = $db->DB_object())!=null)
			 {
			     $pur=htmlentities($_POST[$ligne->id_nivliste]);
			    if( $pur!=0){
				
					ajout_liste_panier($ligne->id_nivliste, $pur, $ligne->forfait);
				}
			 }

			  unset($_POST["envoyer"]);
			 
			 /*
			      faire une redirection vers la liste des elements
			 */
			 
			 }
			 }
			 
			 if(!isset($_GET["id"])){
			 affichage();
			 }else{
			 
			 affichage_contenue_liste($_GET["id"]);
			 
			 unset($_GET["id"]);
			 
			 }
if( isset($_POST["ajouter"])){


 unset($_POST["ajouter"]);
}			 
			 

?>