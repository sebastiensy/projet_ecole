<?php

/*
 * Affiche un formulaire contenant les produits entrées en paramètres.
 * 
 * @param $rubrique
 * @param $srubrique
 * @return void
 *
 * @usage require_once(LIB.'/lib_fournitures.php');
 * afficherFournitures([$rubriques], [$srubriques]);
 *
 */

function afficherFournitures($rubrique="", $srubrique="", $recherche="")
{
	if(!empty($recherche))
	{
		$requete = 'SELECT ref_mat, desc_mat, prix_mat FROM Materiel WHERE desc_mat LIKE \'%'.$recherche.'%\'';
	}
	else
	{
		$requete = 'SELECT m.ref_mat, m.desc_mat, m.prix_mat, sc.categorie, sc.scat FROM Materiel as m, Sous_categorie as sc WHERE m.id_scat = sc.id_scat';

		if(!empty($rubrique))
			$requete .= ' AND sc.categorie = \''.$rubrique.'\'';
		if(!empty($srubrique))
			$requete .= ' AND sc.scat = \''.$srubrique.'\'';
	}

	$db = new DB_connection();
	$db->DB_query($requete);

	echo "<table>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Prix</th>
				<th>Quantite</th>
				<th></th>
			</tr>";
	while($mat = $db->DB_object())
	{
		echo "<tr>
				<td>".$mat->ref_mat."</td>
				<td>".$mat->desc_mat."</td>
				<td>".$mat->prix_mat." €</td>
				<td><input class=\"spinner\" name=\".$mat->ref_mat.\" size=\"1\" min=\"1\" max=\"999\"></td>
				<td><a href=\"index.php?ref=".$mat->ref_mat."\">Ajouter au panier</td>
			</tr>";
	}
	echo "</table>";

	//mysqli_free_result($res);

	// ajouter vérification d'erreurs si la réf n'existe pas
	if(!empty($_GET["ref"]))
	{
		// remplacer '1' avec $_SESSION['id']
		$requete = 'SELECT c.id_commande FROM Commande as c, Parent as p WHERE Etat = 0 AND p.id_parent = c.id_parent AND p.id_parent = 1';
		$db->DB_query($requete);

		if($commande = $db->DB_object())
		{
			$id = $commande->id_commande;

			// pouvoir modifier quantite à l'avenir par un GET
			$requete = 'INSERT INTO Contient (id_commande, ref_mat, quantite) VALUES ("'.$id.'", "'.$_GET["ref"].'", 1)';
			$res = mysqli_query($co, $requete);
			mysqli_free_result($res);
			
			// ajouter un param à l'url pour récupérer res
			header('Location: index.php');
		}
		/*else
		{
			// remplacer '1' avec $_SESSION['id']
			echo "test";
			$requete = 'INSERT INTO Commande (id_commande, date_cmd, etat, id_parent) VALUES (\'\', \'\', \'0\', 1)';
			$res = mysqli_query($co, $requete);
		}*/
	}
	$db->DB_done();
}

?>
