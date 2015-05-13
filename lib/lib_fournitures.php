<?php

/*
 * Affiche un formulaire contenant les produits entrés en paramètres.
 * 
 * @param $rubrique
 * @param $srubrique
 * @return void
 *
 * @usage require_once(LIB.'/lib_fournitures.php');
 * afficherFournitures([$rubrique], [$srubrique], [$recherche]);
 *
 */

function afficherFournitures($panier, $rubrique="", $srubrique="", $recherche="")
{
	if(!empty($recherche))
	{
		$requete = 'SELECT ref_mat, desc_mat, prix_mat FROM Materiel WHERE desc_mat LIKE \'%'.$recherche.'%\' OR ref_mat = \''.$recherche.'\'';
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
	$nb_elems = 22; // nombre d'éléments par page
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

	echo "<div id=\"produits\">";

	if(isset($_SESSION["id_parent"]))
	{
		if(isset($_GET["ref"]))
		{
			$requete2 = 'SELECT ref_mat FROM Materiel WHERE ref_mat = "'.htmlSpecialChars($_GET["ref"]).'"';
			$db->DB_query($requete2);
			if($db->DB_count() > 0)
			{
				$str = "L'article ".$_GET["ref"]." a été ajouté au <a href=\"../panier\">panier</a>";
				if(isset($_GET["qte"]))
				{
					$str .= " en ".$_GET["qte"]." exemplaires.";
				}
				echo "<span style=\"color:green\"><p><strong>$str</strong></p></span>";
			}
		}
	}
	else
	{
		echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour ajouter des produits au panier.</strong></p></span>";
	}

	$db->DB_query($requete);

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
			echo "<form method=\"get\" action=\"\">";
			$tr = "<tr>";
			if(isset($_SESSION["id_parent"]))
			{
				if(isset($_GET["ref"]))
				{
					if($_GET["ref"] == $mat->ref_mat)
					{
						$tr = "<tr bgcolor=\"orange\">";
					}
				}
			}
			echo $tr;
				echo "<td>".$mat->ref_mat."</td>
				<td>".$mat->desc_mat."</td>
				<td>".$mat->prix_mat." €</td>";
				
				$td = "<td><input type=\"number\" name=\"qte\" value=\"1\" size=\"1\" min=\"1\" max=\"20\"></td>";
				if(isset($_SESSION["id_parent"]))
				{
					if(isset($_GET["ref"]) && isset($_GET['qte']))
					{
						if($_GET["ref"] == $mat->ref_mat)
						{
							$td = "<td><input type=\"number\" name=\"qte\" value=".$_GET['qte']." size=\"1\" min=\"1\" max=\"20\"></td>";
						}
					}
				}
				echo $td;
				//echo "<td><a href=\"index.php?page=".$page."&amp;ref=".$mat->ref_mat."&amp;qte=".$i."\">Ajouter au panier</td>";

				echo "<td><input type=\"submit\" value=\"Ajouter au panier\"></td>";
				echo "<td><input type=\"hidden\" name=\"page\" value=\"$page\"></td>";
				if($recherche!="")
				{
					echo "<td><input type=\"hidden\" name=\"find\" value=\"$recherche\"></td>";
				}
				echo "<td><input type=\"hidden\" name=\"cat\" value=\"$rubrique\"></td>";
				echo "<td><input type=\"hidden\" name=\"ref\" value=\"$mat->ref_mat\"></td>";

			echo "</tr>";
			echo "</form>";
		}
		echo "</table>";
	}
	else
	{
		echo "<p>Aucun produit trouvé.</p>";
	}

	echo "</div>";

	if(!empty($_GET["ref"]))
	{
		if(isset($_SESSION["id_parent"]))
		{
			// Vérification d'erreurs si la réf n'existe pas
			$requete3 = 'SELECT id_mat, ref_mat FROM Materiel WHERE ref_mat = "'.htmlSpecialChars($_GET["ref"]).'"';
			$db->DB_query($requete3);
			if($db->DB_count() > 0)
			{	
				if($mat = $db->DB_object())
				{
					$panier->add($mat->id_mat, htmlSpecialChars($_GET["qte"]));
				}

				/*$requete = 'SELECT c.id_commande FROM Commande as c, Parent as p WHERE Etat = 1 AND p.id_parent = c.id_parent AND p.id_parent = '.$_SESSION['id_parent'];
				$db->DB_query($requete);

				if($commande = $db->DB_object())
				{
					$id = $commande->id_commande;

					// pouvoir modifier quantite à l'avenir par un GET
					$requete = 'INSERT INTO Contient (id_commande, ref_mat, quantite) VALUES ("'.$id.'", "'.$_GET["ref"].'", 1)';
					$db->DB_query($requete);
				}*/
				/*else
				{
					// remplacer '1' avec $_SESSION['id']
					echo "test";
					$requete = 'INSERT INTO Commande (id_commande, date_cmd, etat, id_parent) VALUES (\'\', \'\', \'0\', 1)';
					$res = mysqli_query($co, $requete);
				}*/
			}
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
	{
		return true;
	}
	else
	{
		if(empty($_GET["cat"]) && empty($_GET["scat"]) && empty($_GET["find"]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
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
