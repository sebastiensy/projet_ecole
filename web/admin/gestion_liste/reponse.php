<html>
	<head>
	<meta charset="ISO-8859-1">
	</head>
	<body>

<?php

require_once('../inc/data.inc.php');

?>

<?php

if($_GET["reponse"] == 1)
{
	$db = new DB_connection();
	$query = 'SELECT m.id_mat, m.ref_mat, m.desc_mat, m.prix_mat, sc.categorie, sc.scat FROM Materiel as m, Sous_categorie as sc WHERE m.id_scat = sc.id_scat';
	$query .= '  AND sc.categorie = "'.$_POST['id'].'"';
	$db->DB_query($query);
	
	$html = "";
	
	if(($db->DB_count() > 0))
	{
		$html .= "<table>";
			$html .= "<tr>";
				$html .= "<th>Référence</th>";
				$html .= "<th>Description</th>";
				$html .= "<th>Prix</th>";
			$html .= "</tr>";
		while($mat = $db->DB_object())
		{
			$html .= "<tr>";
				$html .= "<td>".$mat->ref_mat."</td>";
				$html .= "<td>".$mat->desc_mat."</td>";
				$html .= "<td>".$mat->prix_mat." €</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";
	}
	echo $html;

	$db->DB_done();
}

?>

	</body>
</html>