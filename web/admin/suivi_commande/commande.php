<?php
	require_once('../inc/data.inc.php');
?>

<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />


<?php

if (isset($_GET['com']) && isset($_GET['nom']))
{
	$id_commande = $_GET['com'];
	$parent = $_GET['nom'];


	$requete = 'SELECT c.id_commande, c.ref_mat, c.quantite, m.desc_mat, m.prix_mat FROM Contient as c, Materiel as m WHERE c.ref_mat = m.ref_mat AND c.id_commande = '.$id_commande;
	$requete2 = 'SELECT c.id_commande, c.id_mat, c.quantite, m.desc_mat, m.prix_mat FROM Contient as c, Materiel as m WHERE c.id_mat = m.id_mat AND c.id_commande = '.$id_commande;

	$db = new DB_connection();
	$db->DB_query($requete2);

	$prix = array();

	echo 'Parent : '.$parent;

	?>
	

	<table width="900" align="center" class="data">
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
			
			echo "<td><div align='center'>".$suiv->quantite * $suiv->prix_mat." €</div></td>";
			
			echo "</tr>";

			array_push($prix, $suiv->quantite * $suiv->prix_mat);
		}
		
		$somme = array_sum($prix);
		
		echo "</table>";

		echo "TOTAL : ".$somme. " €";

		$db->DB_done();
}

?>

<?php
	//require_once('../inc/footer.inc.php');
?>