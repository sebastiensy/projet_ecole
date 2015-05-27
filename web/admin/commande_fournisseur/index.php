<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

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
				<th width="90" ><div align="center">Reference</div></th>
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
    AND com.etat = 2
    GROUP BY mat.id_mat';

/*
 * requete pour les fournitures seules
 */
$requete2 = 'SELECT SUM(c.quantite) as qte, m.desc_mat, m.prix_mat, m.id_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND com.id_commande = c.id_commande 
	AND com.etat = 2
    GROUP BY c.id_mat';

$tab = array();

$db = new DB_connection();
$db->DB_query($requete1);

$prix = array();

while($elem = $db->DB_object())
{
	if(isset($tab[$elem->id_mat]))
		$tab[$elem->id_mat] += $elem->qte;
	else
		$tab[$elem->id_mat] = $elem->qte;	
}

$db->DB_query($requete2);

while($elem = $db->DB_object())
{
	if(isset($tab[$elem->id_mat]))
		$tab[$elem->id_mat] += $elem->qte;
	else
		$tab[$elem->id_mat] = $elem->qte;	
}

$ids = array_keys($tab);


/*
*	ouverture du fichier
*/
$fichierCmdF = fopen('cmdF.txt', 'w+');



if(!empty($ids))
{
	$requete3 = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
	$db->DB_query($requete3);

	if($db->DB_count() > 0)
	{
		while($liste = $db->DB_object())
		{
			echo "<tr><td><div align='center'>".$liste->ref_mat."</div></td>";
			echo "<td><div align='center'>".$liste->desc_mat."</div></td>";
			echo "<td><div align='center'>".$tab[$liste->id_mat]."</div></td>";
			echo "<td><div align='center'>".number_format($liste->prix_mat, 2, ',', ' ')." €</div></td>";
			array_push($prix, $tab[$liste->id_mat] * $liste->prix_mat);

			/*
			*	ecriture dans le fichier
			*/
			fputs($fichierCmdF, $liste->ref_mat.';');
			fputs($fichierCmdF, $liste->desc_mat.';');
			fputs($fichierCmdF, $tab[$liste->id_mat].';');
			fputs($fichierCmdF, number_format($liste->prix_mat, 2, ',', ' ').';');
			fputs($fichierCmdF, "\r\n");
		}
	}
}

echo "</tr>";
echo "</table>";
echo "<br>";

$somme = array_sum($prix);
echo "<div align='center'><strong style='color: red'>TOTAL : ".number_format($somme, 2, ',', ' '). " €</strong></div>";



/*
*	fermeture du fichier
*/
fclose($fichierCmdF);


/*
*	imprimer en pdf
*/
echo "<a href='pdf.php?pt=".$somme."'><img src='../../../img/imprimer.png' border='0'></a>";

/*
*	passer la commande au fournisseur
*/
echo "<form method='POST' action='index.php'><input type='submit' name='cmdFournisseur' value='Passer commande fournisseur'></input></form>";


if (isset($_POST['cmdFournisseur']))
{
	$requete = 'UPDATE Commande SET etat = 3 WHERE etat = 2';
	$db->DB_query($requete);
	echo $requete;
	//echo "";
}

?>


<?php

require_once('../inc/footer.inc.php');

?>