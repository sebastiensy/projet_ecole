<?php

session_start();
require_once('../inc/data.inc.php');

?>

<html>
	<head>
		<title>Interface Administrateur</title>
		<link rel="stylesheet" href="../../../css/style1.css">
	</head>
	<body>

<?php

if (isset($_GET['com']) && isset($_GET['nom']))
{
	$id_commande = $_GET['com'];
	$parent = $_GET['nom'];


	$requete1 = 'SELECT c.quantite, m.desc_mat, m.prix_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND c.id_commande = com.id_commande 
	AND com.etat >= 1 AND c.id_commande = '.$id_commande;
	
	$requete2 = 'SELECT i.exemplaire, ln.forfait, n.libelle
	FROM Commande as com, Inclus as i, Liste_niveau as ln, Niveau as n 
	WHERE com.id_commande = i.id_commande AND i.id_nivliste = ln.id_nivliste AND ln.niveau = n.code 
	AND com.etat >= 1 AND i.id_commande = '.$id_commande;


	$db = new DB_connection();
	$db->DB_query($requete1);

	$prix = array();

	echo '<strong>Parent : '.$parent.'</strong>';

	?>
	
	<br>
	<table width="800" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Quantite</div></th>
		<th width="90" ><div align="center">Materiel</div></th>
		<th width="90" ><div align="center">Prix</div></th>
	</tr>

	<?php
		while($suiv = $db->DB_object())
		{
			echo "<tr><td><div align='center'>".$suiv->quantite."</div></td>";
			
			echo "<td><div align='center'>".$suiv->desc_mat."</div></td>";
			
			echo "<td><div align='center'>".number_format($suiv->quantite * $suiv->prix_mat, 2, ',', ' ')." €</div></td>";
			
			echo "</tr>";

			array_push($prix, $suiv->quantite * $suiv->prix_mat);
		}

		echo "</table>";

	
	$db->DB_query($requete2);
	
	?>
	
	<table width="800" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Quantite</div></th>
		<th width="90" ><div align="center">Liste</div></th>
		<th width="90" ><div align="center">Forfait</div></th>
	</tr>
	<br><br>


	<?php
		while($suiv = $db->DB_object())
		{
			echo "<tr><td><div align='center'>".$suiv->exemplaire."</div></td>";
			
			echo "<td><div align='center'>".$suiv->libelle."</div></td>";
			
			echo "<td><div align='center'>".number_format($suiv->exemplaire * $suiv->forfait, 2, ',', ' ')." €</div></td>";
			
			echo "</tr>";

			array_push($prix, $suiv->exemplaire * $suiv->forfait);
		}


		
		$somme = array_sum($prix);
		
		echo "</table>";
		echo "<br>";

		echo "<strong style='color: red'>TOTAL : ".number_format($somme, 2, ',', ' '). " €</strong>";

	
}

?>

	</body>
</html>