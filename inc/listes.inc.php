<?php

if(isset($_GET["id"]))
{
	$db = new DB_connection();
	$query = 'SELECT n.Libelle, ln.forfait FROM Niveau n, Liste_niveau ln WHERE ln.niveau = n.code AND ln.id_nivliste = '.$_GET["id"];
	$db->DB_query($query);
	$libelle = "";
	$prix = 0;
	if($db->DB_count() > 0)
	{
		if($niveau = $db->DB_object())
		{
			$libelle = $niveau->Libelle;
			$prix = $niveau->forfait;
		}
	}

	$query2 = 'SELECT * FROM Compose c, Materiel m, Liste_niveau ln, Niveau n WHERE c.id_mat = m.id_mat AND c.id_nivliste = ln.id_nivliste AND n.code = ln.niveau AND ln.id_nivliste = '.$_GET["id"];
	$query2 .= ' ORDER BY m.id_mat';
	$db->DB_query($query2);

	echo "<b>Niveau : ".$libelle."</b><br/>";
	echo "<b>Forfait : ".number_format($prix, 2, ',', ' ')." €</b><hr/>";
	if($db->DB_count() > 0)
	{
		echo "<table align=\"center\" class=\"data\">";
		echo "<tr align=\"center\">
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
	else
	{
			echo "<div align=\"center\"><b>La liste est vide.</b></div>";
	}
	echo "</table>";

	$db->DB_done();
}

?>

	</body>
</html>