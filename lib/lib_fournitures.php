<?php

/*
 * Affiche un formulaire contenant les produits entr�s en param�tres.
 * 
 * @param $rubrique
 * @param $srubrique
 * @return void
 *
 * @usage require_once(LIB.'/lib_fournitures.php');
 * afficherFournitures($panier, [$rubrique], [$srubrique], [$recherche]);
 *
 */

function afficherFournitures($panier, $rubrique="", $srubrique="", $recherche="")
{
	$db = new DB_connection();
	$query = 'SELECT jma FROM Date_limite';
	$db->DB_query($query);
	$now = Date("Y-m-d");
	$jma = Date("Y-m-d");
	if($db->DB_count() > 0)
	{
		if($date = $db->DB_object())
		{
			$now = new DateTime($now);
			$now = $now->format('Ymd');
			$jma = new DateTime($date->jma);
			$jma = $jma->format('Ymd');
		}
	}

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

	$db->DB_query($requete);
	$nb_elems = 10; // nombre d'�l�ments par page
	$nb_pages = ceil($db->DB_count() / $nb_elems);

	if(!empty($_GET["page"]))
	{
		$page = intval(htmlentities($_GET["page"], ENT_QUOTES));
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
		if($now < $jma)
		{
			if(isset($_GET["ref"]))
			{
				$requete2 = 'SELECT ref_mat FROM Materiel WHERE ref_mat = "'.$db->quote($_GET["ref"]).'"';
				$db->DB_query($requete2);
				if($db->DB_count() > 0)
				{
					$str = "L'article ".htmlentities($_GET["ref"], ENT_QUOTES)." a �t� ajout� au <a href=\"../panier\">panier</a>";
					if(isset($_GET["qte"]))
					{
						$s = htmlentities($_GET["qte"], ENT_QUOTES) > 1 ? "s" : "";
						$str .= " en ".htmlentities($_GET["qte"], ENT_QUOTES)." exemplaire".$s."&nbsp;";
					}
					echo "<span style=\"color:green; font-size:13pt\"><p><strong>$str</strong><img src=\"../../img/icon_OK.png\"></p></span>";
				}
			}
		}
		else
		{
			echo "<span style=\"color:red; font-size:13pt\"><p><strong>La date limite de commande est pass�e.</strong></p></span>";
		}
	}
	else
	{
		echo "<span style=\"color:red; font-size:13pt\"><p><strong>Veuillez vous connecter pour ajouter des produits au panier.</strong></p></span>";
	}

	$db->DB_query($requete);

	if($db->DB_count() > 0)
	{
		echo "<div class=\"liste\">";
		echo "<table>
				<tr>
					<td>R�f�rence</td>
					<td>Description</td>
					<td>Prix&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>Quantit�</td>
					<td>Action</td>
				</tr>";

		while($mat = $db->DB_object())
		{
			echo "<form method=\"get\" action=\"\">";
			$tr = "<tr>";
			if(isset($_SESSION["id_parent"]))
			{
				if($now < $jma)
				{
					if(isset($_GET["ref"]))
					{
						if($_GET["ref"] == $mat->ref_mat)
						{
							$tr = "<tr bgcolor=\"orange\">";
						}
					}
				}
			}
			echo $tr;
				echo "<td>".$mat->ref_mat."</td>
				<td>".$mat->desc_mat."</td>
				<td>".number_format($mat->prix_mat, 2, ',', ' ')." �</td>";
				
				$td = "<td><input type=\"number\" name=\"qte\" value=\"1\" size=\"1\" min=\"1\" max=\"100\"></td>";
				if(isset($_SESSION["id_parent"]))
				{
					if($now < $jma)
					{
						if(isset($_GET["ref"]) && isset($_GET['qte']))
						{
							if($_GET["ref"] == $mat->ref_mat)
							{
								//$td = "<td><input type=\"number\" name=\"qte\" value=".$_GET['qte']." size=\"1\" min=\"1\" max=\"100\"></td>";
								$td = "<td><input type=\"number\" name=\"qte\" value=\"1\" size=\"1\" min=\"1\" max=\"100\"></td>";
							}
						}
					}
				}
				echo $td;
				//echo "<td><a href=\"index.php?page=".$page."&amp;ref=".$mat->ref_mat."&amp;qte=".$i."\">Ajouter au panier</td>";

				echo "<td><input type=\"submit\" title=\"Ajouter au panier\" value=\"\" class=\"ajPanier\"></td>";

				echo "</tr>";
				echo "<tr>";
				echo "<input type=\"hidden\" name=\"page\" value=\"$page\">";
				if($recherche!="")
				{
					echo "<input type=\"hidden\" name=\"find\" value=\"$recherche\">";
				}
				echo "<input type=\"hidden\" name=\"cat\" value=\"$rubrique\">";
				echo "<input type=\"hidden\" name=\"ref\" value=\"$mat->ref_mat\">";
				echo "</tr>";
				echo "</form>";
		}
		echo "</table>";
	}
	else
	{
		echo "<p>Aucun produit trouv�.</p>";
	}

	echo "</div></div>";

	if(!empty($_GET["ref"]))
	{
		if(isset($_SESSION["id_parent"]))
		{
			if($now < $jma)
			{
				// V�rification d'erreurs si la r�f n'existe pas
				$requete3 = 'SELECT id_mat, ref_mat FROM Materiel WHERE ref_mat = "'.$db->quote($_GET["ref"]).'"';
				$db->DB_query($requete3);
				if($db->DB_count() > 0)
				{
					if($mat = $db->DB_object())
					{
						$panier->add($mat->id_mat, htmlentities($_GET["qte"], ENT_QUOTES));
					}
				}
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

	if($nb_pages > 1)
	{
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