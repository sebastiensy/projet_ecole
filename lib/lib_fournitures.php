<?php

/*
 * Affiche un formulaire contenant les produits entrées en paramètres.
 * 
 * @param $rubrique
 * @param $srubrique
 * @return void
 *
 * @usage require_once(LIB.'/lib_fournitures.php');
 * afficherFournitures([$rubrique], [$srubrique], [$recherche]);
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
	$nb_elems = 28; // nombre d'éléments par page
	$nb_pages = ceil($db->DB_count() / $nb_elems);

	if(!empty($_GET["page"]))
	{
		$page = intval($_GET["page"]);
		if($_GET["page"] > $nb_pages || $_GET["page"] < 1)
			$page = 1;
	}
	else
		$page = 1;

	$debut = ($page - 1) * $nb_elems;

	$requete .= ' LIMIT '.$debut.', '.$nb_elems.'';

	$db->DB_query($requete);

	echo "<div id=\"produits\">";
	
	if($db->DB_count() > 0)
	{
		echo "<table>
				<tr>
					<th>Référence</th>
					<th>Description</th>
					<th>Prix</th>
					<th>Quantité</th>
					<th></th>
				</tr>";
		while($mat = $db->DB_object())
		{
			echo "<tr>
					<td>".$mat->ref_mat."</td>
					<td>".$mat->desc_mat."</td>
					<td>".$mat->prix_mat." €</td>
					<td><input class=\"spinner\" id=\".$mat->ref_mat.\" name=\".$mat->ref_mat.\" value=\"1\" size=\"1\" min=\"1\" max=\"999\" onchange=\"getQte()\"></td>
					<td><a href=\"index.php?page=".$page."&amp;ref=".$mat->ref_mat."&amp;qte=".$mat->ref_mat."\">Ajouter au panier</td>
				</tr>";
		}
		echo "</table>";
	}
	else
	{
		$requete = "SELECT categorie FROM Sous_categorie LIMIT 1";
		$db->DB_query($requete);
		if($cat = $db->DB_object())
			header("Location: index.php?cat=".$cat->categorie);
		else
			header("Location: ../index.php");
	}

	echo "</div>";

	if(!empty($_GET["ref"]))
	{
		// vérification d'erreurs si la réf n'existe pas
		$requete = 'Select ref_mat FROM Materiel WHERE ref_mat = "'.htmlSpecialChars($_GET["ref"]).'"';
		$db->DB_query($requete);
		if($db->DB_count() > 0)
		{
			// remplacer '1' avec $_SESSION['id']
			$requete = 'SELECT c.id_commande FROM Commande as c, Parent as p WHERE Etat = 1 AND p.id_parent = c.id_parent AND p.id_parent = 1';
			$db->DB_query($requete);

			if($commande = $db->DB_object())
			{
				$id = $commande->id_commande;

				// pouvoir modifier quantite à l'avenir par un GET
				$requete = 'INSERT INTO Contient (id_commande, ref_mat, quantite) VALUES ("'.$id.'", "'.$_GET["ref"].'", 1)';
				$db->DB_query($requete);
			}
			/*else
			{
				// remplacer '1' avec $_SESSION['id']
				echo "test";
				$requete = 'INSERT INTO Commande (id_commande, date_cmd, etat, id_parent) VALUES (\'\', \'\', \'0\', 1)';
				$res = mysqli_query($co, $requete);
			}*/
		}
	}

	// affichage des pages

	echo "<div id=\"pages\">";

	$chemin = explode('/', recuperer_url()[4])[0];

	$script = explode('?', $chemin)[0];

	if(aucun_arg($chemin))
		$param = explode('?page', $chemin)[0];
	else
		$param = explode('&amp;page', $chemin)[0];

	for($i=1; $i <= $nb_pages; ++$i)
	{
		if($page == $i)
			echo "<span style=\"font-weight:bold; color:brown\">".$i."</span> | ";
		else
		{
			if(aucun_arg($chemin))
				echo "<a href=".formater_url($script, urlencode($rubrique), urlencode($srubrique), urlencode($recherche))."?page=".$i.">".$i."</a>";
			else
				echo "<a href=".formater_url($script, urlencode($rubrique), urlencode($srubrique), urlencode($recherche))."&amp;page=".$i.">".$i."</a>";
			echo " | ";
		}
	}
	echo "</div>";
	$db->DB_done();
}

function aucun_arg($url)
{
	if(!isset($_GET["cat"]) && !isset($_GET["scat"]) && !isset($_GET["find"]))
		return true;
	else
		return false;
}

function formater_url($script, $cat, $scat, $find)
{
	$str = $script;
	if($find!="")
		return $str."?find=".$find;
	if($cat!="")
	{
		$str .= "?cat=".$cat;
		if($scat!="")
			$str .= "&amp;scat=;".$scat;
	}
	else if($scat!="")
	{
		$str .= "?scat=".$scat;
		if($cat!="")
			$str = $script."?cat=".$cat."&amp;scat=".$scat;
	}
	return $str;
}

?>
