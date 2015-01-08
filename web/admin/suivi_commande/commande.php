<?php

require_once('../inc.php');

?>
<html>
	<head>
		<title>Interface Administrateur</title>
		<link rel="stylesheet" type="text/css" href="../../../css/style_page.css" /> 
		<style type="text/css">
			body{
				background-image:none;
				}
			
			
			</style>
	<head>
	<body>
		
		<header class="tete">
			<img src="../../../img/header.jpg" alt="header">
		<header>
<?php require_once('../nav.php')?>



<?php

if (isset($_GET['com']) && isset($_GET['nom']))
{
	$id_commande = $_GET['com'];
	$parent = $_GET['nom'];

	echo $parent;

	$requete = 'SELECT c.id_commande, c.ref_mat, c.quantite, m.desc_mat, m.prix_mat FROM Contient as c, Materiel as m WHERE c.ref_mat = m.ref_mat AND c.id_commande = '.$id_commande;

	$db = new DB_connection();
	$db->DB_query($requete);

	$prix = array();

		echo "<table>
				<tr>
					<th>Quantite</th>
					<th>Materiel</th>
					<th>Prix</th>
				</tr>";
		
		while($suiv = $db->DB_object())
		{
			echo "<tr><td>".$suiv->quantite."</td>";
			
			echo "<td>".$suiv->desc_mat."</td>";
			
			echo "<td>".$suiv->quantite * $suiv->prix_mat." €</td>";
			
			echo "</tr>";

			array_push($prix, $suiv->quantite * $suiv->prix_mat);
		}
		
		$somme = array_sum($prix);
		
		echo "</table>";

		echo "TOTAL : ".$somme. " €";

		$db->DB_done();
}

?>

</body>
</html>