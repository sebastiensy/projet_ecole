<?php 

function create_function(){
$_SESSION['panier'] = array(); 
$_SESSION['panier']['id_mat'] = array(); 
$_SESSION['panier']['qte'] = array(); 
$_SESSION['panier']['prix'] = array();
$_SESSION['panier']['id_list'] = array();
$_SESSION['panier']['prix_list'] = array();

}


/***
**
*
  ajoute un element dans le panier
*
**
*/

function ajout_panier($select) 
{ 
    array_push($_SESSION['panier']['id_mat'],$select['id']); 
    array_push($_SESSION['panier']['qte'],$select['qte']);  
    array_push($_SESSION['panier']['prix'],$select['prix']); 
}


/** 
 * Vérifie la présence d'un article dans le panier 
 * 
  
 */ 
function verif_panier($ref_mat) 
{ 
    /* On initialise la variable de retour */ 
    $present = false; 
    /* On vérifie les numéros de références des articles et on compare avec l'article à vérifier */ 
    if( count($_SESSION['panier']['id_mat']) > 0 && array_search($ref_mat,$_SESSION['panier']['id_mat']) !== false) 
    { 
        $present = true; 
    } 
    return $present; 
}


/**


cette fonction permet de modifier la quantité d un article prensent dans le panier


*/

function modif_qte($ref_mat, $qte) 
{ 
    /* On compte le nombre d'articles différents dans le panier */ 
    $nb_articles = count($_SESSION['panier']['id_mat']); 
    /* On initialise la variable de retour */ 
    $ajoute = false; 
    /* On parcoure le tableau de session pour modifier l'article précis. */ 
    for($i = 0; $i < $nb_articles; $i++) 
    { 
        if($ref_article == $_SESSION['panier']['id_mat'][$i]) 
        { 
            $_SESSION['panier']['qte'][$i] = $qte; 
            $ajoute = true; 
        } 
    } 
    return $ajoute; 
} 


/****************************

     cette fonction suprime un article du panier


*********************************
*/

function supprim_article($ref_mat) 
{ 
    $suppression = false; 
    /* création d'un tableau temporaire de stockage des articles */ 
    $panier_tmp = array("id_mat"=>array(),"qte"=>array(),"prix"=>array()); 
    /* Comptage des articles du panier */ 
    $nb_articles = count($_SESSION['panier']['id_mat']); 
    /* Transfert du panier dans le panier temporaire */ 
    for($i = 0; $i < $nb_articles; $i++) 
    { 
        /* On transfère tout sauf l'article à supprimer */ 
        if($_SESSION['panier']['id_mat'][$i] != $ref_mat) 
        { 
            array_push($panier_tmp['id_mat'],$_SESSION['panier']['id_mat'][$i]); 
            array_push($panier_tmp['qte'],$_SESSION['panier']['qte'][$i]);  
            array_push($panier_tmp['prix'],$_SESSION['panier']['prix'][$i]); 
        } 
    } 
    /* Le transfert est terminé, on ré-initialise le panier */ 
    $_SESSION['panier'] = $panier_tmp; 
    /* Option : on peut maintenant supprimer notre panier temporaire: */ 
    unset($panier_tmp); 
    $suppression = true; 
    return $suppression; 
} 


function remplire_le_panier($etat){


$db=DB_connection();
$requete="select id_commande from commande where id_parent=".$_SESSION['id_parent']."and etat=1";
$db.DB_query($requete);
$row=db->DB_object();
$_SESSION['id_commande']=$row->id_commande;

$requete="select contient.ref_mat,contient.quantite,materiel.prix from contient,materiel where id_commande=".$_SESSION['id_commande']." and contient.ref_mat=materiel.ref_mat";
$db.DB_query($requete);
while($row=db->DB_object()){


    array_push($_SESSION['panier']['id_mat'],$row->id_mat); 
    array_push($_SESSION['panier']['qte'],$row->quantite);  
    array_push($_SESSION['panier']['prix'],$row->prix); 

}



}


/*

        sauvegarde le panier dans la table commande 

*/

function sauvegarder_le_panier($etat=1){

$db=DB_connection();
$nb_articles = count($_SESSION['panier']['id_mat']);

for($i = 0; $i < $nb_articles; $i++) {
$requete="INSERT INTO contient VALUES (".$_SESSION['id_commande'].",".$_SESSION['panier']['id_mat'][$i].",".$_SESSION['panier']['qte'][$i].")";
$db.DB_query($requete);
}

$requete="UPDATE commande SET etat=".etat." where id_commande=".$_SESSION['id_commande'];
$db.DB_query($requete);

}

  
?>