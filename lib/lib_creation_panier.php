<?php 

function create_fonction()
{
	$_SESSION['panier'] = array(); 
	$_SESSION['panier']['id_mat'] = array(); 
	$_SESSION['panier']['qte'] = array(); 
	$_SESSION['panier']['prix'] = array();
	$_SESSION['panier']['id_list'] = array();
	$_SESSION['panier']['qte_list'] = array();
	$_SESSION['panier']['prix_list'] = array();
}

/*
 * Ajoute un element dans le panier
 *
 */
function ajout_panier($id, $qte, $prix) 
{ 
    array_push($_SESSION['panier']['id_mat'],$id); 
    array_push($_SESSION['panier']['qte'],$qte);
    array_push($_SESSION['panier']['prix'],$prix);
}

/*
 * Ajoute une liste
 *
 */
function ajout_liste_panier($id, $qte, $prix)
{
	array_push($_SESSION['panier']['id_list'],$id); 
    array_push($_SESSION['panier']['qte_list'],$qte);  
    array_push($_SESSION['panier']['prix_list'],$prix); 
}

/*
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

/*
 * Modifie la quantité d'un article présent dans le panier
 *
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
        if($ref_mat == $_SESSION['panier']['id_mat'][$i]) 
        { 
            $_SESSION['panier']['qte'][$i] += $qte; 
            $ajoute = true; 
        } 
    } 
    return $ajoute; 
} 

/*
 * Supprime un article du panier
 *
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

/*
 * Rempli le panier à la connexion
 *
 */
function remplir_le_panier()
{
	$db=new DB_connection();
	$requete="select id_commande from Commande where id_parent=".$_SESSION['id_parent']." and etat=1";
	$db->DB_query($requete);
	$row=$db->DB_object();
	if(!$row==null)
	{
		$_SESSION['id_commande']=$row->id_commande;

		$requete="select Contient.ref_mat,Contient.quantite,Materiel.prix_mat from Contient,Materiel where id_commande=".$_SESSION['id_commande']." and Contient.ref_mat=Materiel.ref_mat";
		$db->DB_query($requete);
		while($row=$db->DB_object())
		{
			array_push($_SESSION['panier']['id_mat'],$row->ref_mat); 
			array_push($_SESSION['panier']['qte'],$row->quantite);  
			array_push($_SESSION['panier']['prix'],$row->prix_mat); 
		}

		/*
		remplir le panier avec les liste commander
		*/
		$requete="select Liste_niveau.forfait,Inclus.exemplaire,Liste_niveau.id_nivliste from Liste_niveau,Inclus where Inclus.id_commande=".$_SESSION['id_commande']." and Inclus.id_nivliste=Liste_niveau.id_nivliste";
		$db->DB_query($requete);
		while($row=$db->DB_object())
		{
			array_push($_SESSION['panier']['id_list'],$row->id_nivliste); 
			array_push($_SESSION['panier']['qte_list'],$row->exemplaire);  
			array_push($_SESSION['panier']['prix_list'],$row->forfait); 
		}
	}
}

/*
 * Sauvegarde le panier dans la table commande
 *
 */
function sauvegarder_le_panier($etat=1)
{
	/*
		sauvgarde des element materiel commander seul
	*/
	$db=new DB_connection();
	$nb_articles = count($_SESSION['panier']['id_mat']);

	$requete="DELETE FROM contient where id_commande=".$_SESSION['id_commande'];
	$db->DB_query($requete);
	for($i = 0; $i < $nb_articles; $i++)
	{
		$requete="INSERT INTO contient VALUES (".$_SESSION['id_commande'].",".$_SESSION['panier']['id_mat'][$i].",".$_SESSION['panier']['qte'][$i].")";
		$db->DB_query($requete);
	}
	/*
		 sauvgarde des listes selectionner
	*/
	$nb_articles = count($_SESSION['panier']['id_list']);

	$requete="DELETE FROM inclus where id_commande=".$_SESSION['id_commande'];
	$db->DB_query($requete);

	for($i = 0; $i < $nb_articles; $i++)
	{
		$requete="INSERT INTO inclus VALUES (".$_SESSION['id_commande'].",".$_SESSION['panier']['id_list'][$i].",".$_SESSION['panier']['qte_list'][$i].")";
		$db->DB_query($requete);
	}

	/*
		mise ajour de l etat de la commande
	*/
	$requete="UPDATE commande SET etat=".etat." where id_commande=".$_SESSION['id_commande'];
	$db->DB_query($requete);
}

/*
 * Affiche le panier
 *
 */
function afficher_le_panier()
{
	$db = new DB_connection();
	$requete = "select id_commande from Commande where id_parent=".$_SESSION['id_parent'] ;
	//and etat=1";
	$db->DB_query($requete);

	if($db->DB_count() == 0)
	{
		$vide = true;
	}

	while(($row = $db->DB_object()) != null)
	{
		// Récupere l'id de la commande du client 
		$_SESSION['id_commande'] = $row->id_commande;

		// Récupere les éléments commandés seuls
		$requete = "select Contient.ref_mat, Contient.quantite, Materiel.prix_mat, Materiel.desc_mat from Contient, Materiel where id_commande=".$_SESSION['id_commande']." and Contient.ref_mat=Materiel.ref_mat";
		$db->DB_query($requete);

		$somme_element=0;
		$somme_list=0;
		header_element_panier();
		while($row=$db->DB_object())
		{
			affichage_element_panier($row->desc_mat, $row->quantite, $row->prix_mat);
		}
		footer_panier();

		// Récupere les listes commandées par le client 
		$requete="select Inclus.id_nivliste, Inclus.exemplaire, Liste_niveau.forfait, Liste_niveau.niveau from Inclus, Liste_niveau where Inclus.id_commande=".$_SESSION['id_commande']." and Inclus.id_nivliste=Liste_niveau.id_nivliste";
		$db->DB_query($requete);

		if($db->DB_count() > 0)
		{
			header_list_panier();
		}

		// Affichage des liste ajoutées
		while($row=$db->DB_object())
		{
			$somme_element += affichage_list_panier($row->niveau, $row->exemplaire, $row->forfait);
		}

		?>
			<tr>
				<td colspan="2"><?php $somme_element ?></td>
			</tr>
		<?php
		footer_panier();
	}
	
	if(isset($vide))
	{
		if($vide)
		{
				echo "<strong>Votre panier est vide.</strong>";
		}
	}
}

function affichage_element_panier($desc,$qte,$prix)
{
	?>
	  <tr>
		   <td><?php echo $desc;?></td>
		   <td><?php echo $qte;?></td>
		   <td><?php echo $prix;?></td>
		   <td><?php echo $prix*$qte;?></td>
	   </tr>

	<?php
		return $prix*$qte;
}

function footer_panier()
{
	echo "</table>";
}
  
function header_element_panier()
{
	?>
	 <table>
	   <tr>
		   <th>Description</th>
		   <th>Quantit&eacute;</th>
		   <th>Prix</th>
		   <th>Total</th>
	   </tr>
	<?php
}  

function header_list_panier()
{
	?>
	 <table>
	  
	   <tr>
		   <th>Niveau liste</th>
		   <th>Quantit&eacute; </th>
		   <th>Prix</th>
		   <th>Total</th>
	   </tr>
	<?php
}

function affichage_list_panier($desc,$qte,$prix)
{
	?>
	<tr>
		<td><?php echo $desc;?></td>
		<td><?php echo $qte;?></td>
		<td><?php echo $prix;?></td>
		<td><?php echo $prix*$qte;?></td>
	</tr>
	<?php
		return $prix*$qte;
}

?>