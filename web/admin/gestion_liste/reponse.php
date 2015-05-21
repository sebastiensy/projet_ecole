<html>
	<head>
		<meta charset="ISO-8859-1">
	</head>
	<body>

<?php

session_start();
require_once('../inc/data.inc.php');

?>

<?php
if(!isset($_SESSION['droits']))
{
	header("Location: ../../index.php");
}
else
{
	if($_SESSION['droits'] != 1)
	{
		header("Location: ../../index.php");
	}
}
?>

<?php

/*function afficherPrix()
{
	return number_format($_POST["prix"] * (100-$_POST["reduc"]) / 100, 2, ',', ' ');
}*/

function newList()
{
	$db = new DB_connection();

	$ids = array_keys($_SESSION['four']);
	if(!empty($ids))
	{
		$query = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
		$db->DB_query($query);
		//$prix = 0;//

		if($db->DB_count() > 0)
		{
			$html = "";
			$html .= "<table class=\"data\">";
				$html .= "<tr>";
					$html .= "<th>Référence</th>";
					$html .= "<th>Description</th>";
					$html .= "<th>Quantité</th>";
					$html .= "<th></th>";
				$html .= "</tr>";
				while($mat = $db->DB_object())
				{
					//$prix += $mat->prix_mat * $_SESSION["four"][$mat->id_mat];//
					$html .= "<tr>";
						$html .= "<td>".$mat->ref_mat."</td>";
						$html .= "<td>".$mat->desc_mat."</td>";
						$html .= "<td><input type=\"number\" onChange=modifierQte(".$mat->id_mat.") id=A".$mat->id_mat." name=\"qte\" value=".$_SESSION["four"][$mat->id_mat]." size=\"1\" min=\"1\" max=\"20\"></td>";
						$html .= "<td><div onClick=supprimerFourniture(".$mat->id_mat.")><img id=\"click\" title=\"Supprimer\" src=\"../../../img/del2.png\"></div></td>";
					$html .= "</tr>";
				}
				$html .= "</table>";
				$db->DB_done();
				//$prix = $prix * (100-$_POST["reduc"]) / 100;//
				//$html .= "<input type=\"hidden\" id=\"prix\" value=".$prix.">";//
				return $html;
		}
	}
}

?>

<?php

if($_GET["reponse"] == 1)
{
	$db = new DB_connection();
	$query = 'SELECT m.id_mat, m.ref_mat, m.desc_mat, m.prix_mat, sc.categorie, sc.scat FROM Materiel as m, Sous_categorie as sc WHERE m.id_scat = sc.id_scat';
	$query .= '  AND sc.categorie = "'.$_POST['id'].'"';
	$query .= ' ORDER BY id_mat';
	$db->DB_query($query);

	$html = "";
	if(($db->DB_count() > 0))
	{
		$html .= "<table class=\"data\">";
			$html .= "<tr>";
				$html .= "<th>Référence</th>";
				$html .= "<th>Description</th>";
				$html .= "<th>Quantité</th>";
				$html .= "<th></th>";
			$html .= "</tr>";
		while($mat = $db->DB_object())
		{
			$html .= "<tr>";
				$html .= "<td>".$mat->ref_mat."</td>";
				$html .= "<td>".$mat->desc_mat."</td>";
				//$html .= "<td><input type=\"number\" id=".$mat->id_mat." onChange=recupererQte(".$mat->id_mat.") name=\"qte\" value=\"1\" size=\"1\" min=\"1\" max=\"20\"></td>";
				$html .= "<td><input type=\"number\" id=".$mat->id_mat." name=\"qte\" value=\"1\" size=\"1\" min=\"1\" max=\"20\"></td>";
				//$html .= "<td><div id=A".$mat->id_mat."><a onClick=\"\" id=\"B".$mat->id_mat."\" href=\"ajouter_liste.php?id=".$mat->id_mat."&amp;qte=1\"><img title=\"Ajouter\" src=\"../../../img/icon_add.png\"></a></div></td>";
				$html .= "<td><div onClick=ajouterFourniture(".$mat->id_mat.")><img id=\"click\" title=\"Ajouter\" src=\"../../../img/icon_add.png\"></div></td>";
			$html .= "</tr>";
		}
		$html .= "</table>";
	}
	echo $html;

	$db->DB_done();
}
else if($_GET["reponse"] == 2)
{
	if(!isset($_SESSION["four"]))
	{
		$_SESSION["four"] = array();
	}
	if(isset($_SESSION["four"][$_POST["id"]]))
	{
		$_SESSION["four"][$_POST["id"]] += $_POST["qte"];
	}
	else
	{
		$_SESSION["four"][$_POST["id"]] = $_POST["qte"];
	}
	echo newList();
}
else if($_GET["reponse"] == 3)
{
	if(isset($_SESSION["four"][$_POST["id"]]))
	{
		$_SESSION["four"][$_POST["id"]] = $_POST["qte"];
		echo newList();
	}
}
else if($_GET["reponse"] == 4)
{
	if(isset($_SESSION["four"][$_POST["id"]]))
	{
		unset($_SESSION["four"][$_POST["id"]]);
		echo newList();
	}
}
/*else if($_GET["reponse"] == 5)
{				
	echo afficherPrix();
}*/

?>

	</body>
</html>