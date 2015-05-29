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

<?php

if (isset($_POST['cmdFournisseur']))
{
	$db = new DB_connection();

	/*
	*	envoi une notification aux parents qui passent de validé à commande fournisseur
	*/
	$select = 'SELECT p.id_parent, p.email_parent, c.id_commande
				FROM Parent as p, Commande as c
				WHERE p.id_parent = c.id_parent
				AND c.etat = 2';
	$db->DB_query($select);

	$notif = 'INSERT INTO Message (email_parent, objet, message, jma, lu, utilisateur, id_parent) VALUES';

	if($db->DB_count() > 0)
	{
		while($parent = $db->DB_object())
		{
			$notif .= '("'.$parent->email_parent.'", "Commande n° '.$parent->id_commande.'", "Modification de l\'état de la commande n° '.$parent->id_commande.' : Commande fournisseur", NOW(), 0, 0, '.$parent->id_parent.'),';
		}
	}
	$notif = substr($notif, 0, -1);
	$db->DB_query($notif);

	/*
	*	passe les commandes validées à commande fournisseur
	*/
	$update = 'UPDATE Commande SET etat = 3 WHERE etat = 2';
	$db->DB_query($update);

	echo "<p>Toutes les commandes validées sont passées à l'état \"Commande fournisseur\".</p>";

}
else
{
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

	if(!empty($ids))
	{
		$requete3 = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
		$db->DB_query($requete3);

		if($db->DB_count() > 0)
		{
			?>
			<table width="800" align="center" class="data">
				<tr>
					<th width="90" ><div align="center">Reference</div></th>
					<th width="90" ><div align="center">Materiel</div></th>
					<th width="90" ><div align="center">Quantite</div></th>
					<th width="90" ><div align="center">Prix</div></th>
				</tr>
			<?php
			while($liste = $db->DB_object())
			{
				echo "<tr><td><div align='center'>".$liste->ref_mat."</div></td>";
				echo "<td><div align='center'>".$liste->desc_mat."</div></td>";
				echo "<td><div align='center'>".$tab[$liste->id_mat]."</div></td>";
				echo "<td><div align='center'>".number_format($liste->prix_mat, 2, ',', ' ')." €</div></td>";
				array_push($prix, $tab[$liste->id_mat] * $liste->prix_mat);
			}
		
			echo "</tr>";
			echo "</table>";
			echo "<br>";

			$somme = array_sum($prix);
			echo "<div align='center'><strong style='color: red'>TOTAL : ".number_format($somme, 2, ',', ' '). " €</strong></div>";

			/*
			*	imprimer en pdf
			*/
			echo "<form method='POST' action='index.php'><a href='pdf.php' target='_blank'><img src='../../../img/imprimer.png' id='impCmdF' border='0'></a>";

			/*
			*	passer la commande au fournisseur
			*/
			echo "<input type='submit' id='btnCmdF' name='cmdFournisseur' value='Passer commande fournisseur'></input></form>";
		}
	}
	else
	{
		echo "<p>Il n'y a pas de commandes validées.</p>";
	}
}

?>

<?php

require_once('../inc/footer.inc.php');

?>