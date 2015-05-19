<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<body>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<table width="900" align="center" class="entete">
			<tr>
				<td ><div align="right">Commande fournisseur</div></td>
			</tr>
		</table>

		<br>
		<table width="800" align="center" class="data">
			<tr>
				<th width="90" ><div align="center">Materiel</div></th>
				<th width="90" ><div align="center">Quantite</div></th>
				<th width="90" ><div align="center">Prix</div></th>
			</tr>

<?php

/*
 * requete pour liste
 */
$requete1 = 'SELECT SUM(cp.qte_scat*i.exemplaire) as qte , mat.desc_mat, mat.prix_mat, mat.id_mat
	FROM Compose as cp, Materiel as mat, Inclus as i, Commande as com
    WHERE mat.id_mat = cp.id_mat AND cp.id_nivliste = i.id_nivliste AND i.id_commande = com.id_commande
    GROUP BY mat.id_mat';

/*
 * requete pour les fournitures seules
 */
$requete2 = 'SELECT SUM(c.quantite) as qte, m.desc_mat, m.prix_mat, m.id_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND com.id_commande = c.id_commande 
	AND com.etat >= 2
    GROUP BY c.id_mat';

$tab = array();

$db = new DB_connection();
$db->DB_query($requete1);

$prix = array();


while($elem = $db->DB_object())
{
	if (isset($tab[$elem->id_mat]))
		$tab[$elem->id_mat] += $elem->qte;
	else
		$tab[$elem->id_mat] = $elem->qte;	
}

$db->DB_query($requete2);

while($elem = $db->DB_object())
{
	if (isset($tab[$elem->id_mat]))
		$tab[$elem->id_mat] += $elem->qte;
	else
		$tab[$elem->id_mat] = $elem->qte;	
}

$ids = array_keys($tab);

if(!empty($ids))
{
	$requete3 = 'SELECT id_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
	$db->DB_query($requete3);

	if($db->DB_count() > 0)
	{
		while($liste = $db->DB_object())
		{
			echo "<tr><td><div align='center'>".$liste->desc_mat."</div></td>";
			echo "<td><div align='center'>".$tab[$liste->id_mat]."</div></td>";
			echo "<td><div align='center'>".$liste->prix_mat."</div></td>";
			array_push($prix, $tab[$liste->id_mat] * $liste->prix_mat);
		}
	}
}

echo "</tr>";
echo "</table>";

$somme = array_sum($prix);
echo "<strong style='color: red'>TOTAL : ".number_format($somme, 2, ',', ' '). " €</strong>";



?>


<?php

require_once('../inc/footer.inc.php');

?>