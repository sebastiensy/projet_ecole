<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');

?>

<?php

if (isset($_GET['com']) && isset($_GET['nom']))
{
	$id_commande = $_GET['com'];
	$parent = $_GET['nom'];

	/*
	 * pour affiche les listes
	 */
	$requete1 = 'SELECT i.exemplaire, ln.forfait, n.libelle
	FROM Commande as com, Inclus as i, Liste_niveau as ln, Niveau as n 
	WHERE com.id_commande = i.id_commande AND i.id_nivliste = ln.id_nivliste AND ln.niveau = n.code 
	AND com.etat >= 1 AND i.id_commande = '.$id_commande;


	/*
	 * pour afficher les founitures seules
	 */
	$requete2 = 'SELECT c.quantite, m.desc_mat, m.prix_mat, m.ref_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND c.id_commande = com.id_commande 
	AND com.etat >= 1 AND c.id_commande = '.$id_commande;


	$db = new DB_connection();

	$prix = array();

	echo '<strong>Parent : '.$parent.'</strong>';
	
	$db->DB_query($requete1);
	
	?>
	
	<table width="800" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Liste</div></th>
		<th width="90" ><div align="center">Quantite</div></th>
		<th width="90" ><div align="center">Forfait</div></th>
	</tr>
	<br><br>


	<?php
		while($suiv = $db->DB_object())
		{
			echo "<tr><td><div align='center'>".$suiv->libelle."</div></td>";
			
			echo "<td><div align='center'>".$suiv->exemplaire."</div></td>";
			
			echo "<td><div align='center'>".number_format($suiv->forfait, 2, ',', ' ')." €</div></td>";
			
			echo "</tr>";

			array_push($prix, $suiv->exemplaire * $suiv->forfait);
		}
		echo "</table>";

	
	$db->DB_query($requete2);
	
	?>
	<br>
	<table width="800" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Reference</div></th>
		<th width="90" ><div align="center">Materiel</div></th>
		<th width="90" ><div align="center">Quantite</div></th>
		<th width="90" ><div align="center">Prix unitaire</div></th>
	</tr>

	<?php
		while($suiv = $db->DB_object())
		{
			echo "<tr><td><div align='center'>".$suiv->ref_mat."</div></td>";

			echo "<td><div align='center'>".$suiv->desc_mat."</div></td>";
			
			echo "<td><div align='center'>".$suiv->quantite."</div></td>";
			
			echo "<td><div align='center'>".number_format($suiv->prix_mat, 2, ',', ' ')." €</div></td>";
			
			echo "</tr>";

			array_push($prix, $suiv->quantite * $suiv->prix_mat);
		}

		echo "</table>";


		
		$somme = array_sum($prix);
		
		
		echo "<br>";

		echo "<strong style='color: red'>TOTAL : ".number_format($somme, 2, ',', ' '). " €</strong>";

	
}

?>

	</body>
</html>