<html>
	<head>
		<meta charset="ISO-8859-1">
	</head>
	<body>

<?php 
session_start();

require_once('../data/config.php');
require_once('lib_db.class.php');
require_once('lib_workflow.php');

function modif_liste()
{
	$db = new DB_connection();

	$ids = array_keys($_SESSION['listeM']);
	if(!empty($ids))
	{
		$query = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
		$db->DB_query($query);

		if($db->DB_count() > 0)
		{
			$prix = 0;
			$html = "";
			$html .= "<table align=\"center\" class=\"data\">";
				$html .= "<tr>";
					$html .= "<th>Rérérence</th>";
					$html .= "<th>Description</th>";
					$html .= "<th>Prix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>";
					$html .= "<th>Quantité</th>";
					$html .= "<th></th>";
				$html .= "</tr>";
				while($mat = $db->DB_object())
				{
					$prix += $mat->prix_mat * $_SESSION["listeM"][$mat->id_mat];
					$html .= "<tr>";
						$html .= "<td>".$mat->ref_mat."</td>";
						$html .= "<td>".$mat->desc_mat."</td>";
						$html .= "<td align=\"center\">".number_format($mat->prix_mat, 2, ',', ' ')." €</td>";
						$html .= "<td><input type=\"number\" onChange=modifQte(".$mat->id_mat.") id=A".$mat->id_mat." name=\"qte\" value=".$_SESSION["listeM"][$mat->id_mat]." size=\"1\" min=\"1\" max=\"100\"></td>";
						$html .= "<td><div onClick=supprFour(".$mat->id_mat.")><img id=\"click\" title=\"Supprimer\" src=\"../../img/del.png\"></div></td>";
					$html .= "</tr>";
				}
				$html .= "</table>";
				$html .= "<p><div id=\"ptotal\" value=".$prix.">Total : ".number_format($prix, 2, ',', ' ')." €</div></p>";
				$html .= "<form method=\"post\" action=\"\">";
					$html .= "<input type=\"submit\" title=\"Ajouter au panier\" name=\"enr\" value=\"Ajouter au panier\">";
				$html .= "</form>";
				$db->DB_done();
				return $html;
		}
	}
}

if($_GET["reponse"] == 1)
{
	echo affiche_workflow();
}
else if($_GET["reponse"] == 2)
{
	if(isset($_SESSION["listeM"][$_POST["id"]]))
	{
		$_SESSION["listeM"][$_POST["id"]] = $_POST["qte"];
		echo modif_liste();
	}
}
else if($_GET["reponse"] == 3)
{
	if(isset($_SESSION["listeM"][$_POST["id"]]))
	{
		unset($_SESSION["listeM"][$_POST["id"]]);
		echo modif_liste();
	}
}
else if($_GET["reponse"] == 4)
{
	if(isset($_SESSION["listeM"]))
	{
		echo modif_liste();
	}
}

?>

	</body>
</html>