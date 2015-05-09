<!-- INSERT INTO Compose VALUES(1,1,1);
INSERT INTO Compose VALUES(1,46,1);
-->

<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');

?>

<html>
	<head>
		<title>Projet &eacute;cole</title>
		<link rel="stylesheet" href="../../css/liste.css">
	</head>
	<body>

<?php

if(isset($_GET["id"]))
{
	$db = new DB_connection();
	$query = 'SELECT n.Libelle FROM NIveau n, Liste_niveau ln WHERE ln.niveau = n.code';
	$db->DB_query($query);
	if($db->DB_count() > 0)
	{
		$libelle = $db->DB_object()->Libelle;
	}

	$query2 = 'SELECT * FROM Compose c, Materiel m, Liste_niveau ln, Niveau n WHERE c.id_mat = m.id_mat AND c.id_nivliste = ln.id_nivliste AND n.code = ln.niveau';
	$db->DB_query($query2);

	if($db->DB_count() > 0)
	{
		echo "<b>Niveau : ".$libelle."</b><hr/>";
		echo "<table align=\"center\">";
		echo "<tr id=\"entete\" align=\"center\">
						<th>Référence</th>
						<th>Description</th>
						<th>Quantité</th>
					</tr>";
		while($mat = $db->DB_object())
		{
			echo "<tr align=\"center\">
							<td>".$mat->ref_mat."</td>
							<td>".$mat->desc_mat."</td>
							<td>".$mat->qte_scat."</td>
						</tr>";
		}
	}
	echo "</table>";

	$db->DB_done();
}

?>

	</body>
</html>