<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
require_once('../../../lib/lib_message.php');

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
				<td ><div align="right">Suivi des Commandes</div></td>
			</tr>
		</table>

<?php 
if (isset($_POST['purger']))
	{
		$db = new DB_connection();

		/*
		*	purge les commandes retirées et payées
		*/
		$select = 'SELECT id_commande FROM Commande WHERE etat = 6';
		$db->DB_query($select);

		if ($db->DB_count() > 0)
		{
			$purgerCon = 'DELETE FROM Contient WHERE id_commande IN ('.$select.')';
			$db->DB_query($purgerCon);

			$purgerInc = 'DELETE FROM Inclus WHERE id_commande IN ('.$select.')';
			$db->DB_query($purgerInc);

			$purgerCom = 'DELETE FROM Commande WHERE etat = 6';
			$db->DB_query($purgerCom);
		}




		/*$tab = array();

		/*
		* affiche les materiels retire et paye
		*/
		/*$requete2 = 'SELECT c.quantite, m.desc_mat, m.prix_mat, m.ref_mat, m.id_mat, com.id_parent
		FROM Contient as c, Materiel as m, Commande as com
		WHERE c.id_mat = m.id_mat AND c.id_commande = com.id_commande
		AND com.etat = 6';

		$db->DB_query($requete2);


		while($elem = $db->DB_object())
		{
			if(isset($tab[$elem->id_mat]))
				$tab[$elem->id_mat] = $elem->quantite;
			else
				$tab[$elem->id_mat] = $elem->quantite;
		}*/

		/*
		* ajoute l'id parent et la date (table Com_archive)
		*/
		/*$requete2 .= ' GROUP BY com.id_parent';
		$db->DB_query($requete2);
		$dateJour = date('Y-m-d');
		$saveCom = 'INSERT INTO Com_archive (date_archive, id_parent) VALUES';
		while($elem = $db->DB_object())
		{		
			$saveCom .= '("'.$dateJour.'", '.$elem->id_parent.'),';
		}
		$saveCom = substr($saveCom, 0, -1);
		$db->DB_query($saveCom);
		$idCom = $db->DB_id();




		//var_dump($tab);

		$ids = array_keys($tab);

		if(!empty($ids))
		{
			$requete3 = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
			$db->DB_query($requete3);
			if($db->DB_count() > 0)
			{
				$saveMat = 'INSERT INTO Mat_archive (ref_matA, desc_matA, prix_matA) VALUES';
				$saveQte = 'INSERT INTO ContientA (id_comArchive, qte_matA) VALUES';

				while($liste = $db->DB_object())
				{
					$saveMat .= '("'.$liste->ref_mat.'", "'.$liste->desc_mat.'", '.$liste->prix_mat.'),';
					$saveQte .= '('.$idCom.', '.$tab[$liste->id_mat].'),';
				}

				$saveMat = substr($saveMat, 0, -1);
				$saveQte = substr($saveQte, 0, -1);
    			$db->DB_query($saveMat);
    			$db->DB_query($saveQte);
			}
		}

		$requete4 = 'SELECT cA.id_matA, comA.id_comArchive 
		FROM Mat_archive as mA, Materiel as m, Commande as com, ContientA as cA, Contient as c, Com_archive as comA
		WHERE cA.id_matA = mA.id_matA AND mA.ref_matA = m.ref_mat AND m.id_mat = c.id_mat AND c.id_commande = com.id_commande AND com.id_parent = comA.id_parent
		AND com.etat = 6';
		$db->DB_query($requete4);

		$req="";
		while($modif = $db->DB_object())
		{
			$req .= 'UPDATE ContientA SET id_comArchive = '.$modif->id_comArchive.' WHERE id_matA = '.$modif->id_matA.';';
		}
		echo $req;
		$db->DB_query($req);*/

	}
?>		

		<div id="accordion-resizer">
<?php

$requete = 'SELECT p.id_parent, p.nom_parent, c.etat, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND c.etat > 0 GROUP BY p.id_parent';

$db = new DB_connection();
$db->DB_query($requete);

if(isset($_GET['com']))
{
	$commande = $_GET['com'];
}
else
{
	$commande = "";
}

while($suiv = $db->DB_object())
{
	echo '<h3>'.$suiv->nom_parent.'</h3>';
	?>
	<div>
	<table width="900" align="center" class="data">
		<tr>
			<th width="90" ><div align="center">Numero de commande</div></th>
			<th width="90" ><div align="center">En cours de validation</div></th>
			<th width="90" ><div align="center">Validé</div></th>
			<th width="90" ><div align="center">Commande fournisseur</div></th>
			<th width="90" ><div align="center">En cours de livraison</div></th>
			<th width="90" ><div align="center">Livré</div></th>
			<th width="90" ><div align="center">Retiré et payé</div></th>
			<th width="90" ><div align="center"></div></th>
			<th width="90" ><div align="center"></div></th>
			<th width="90" ><div align="center"></div></th>
		</tr>
	<?php
	$requete2 = 'SELECT p.id_parent, p.nom_parent, p.email_parent, c.etat, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND c.etat > 0 AND p.id_parent = '.$suiv->id_parent.'';

	$db2 = new DB_connection();

	$db2->DB_query($requete2);

	while($suiv2 = $db2->DB_object())
	{
	?>
		<?php
			echo "<tr><td><div align='center'>".$suiv2->id_commande."</div></td>";
			if ($commande != $suiv2->id_commande)
			{
			echo '<form method="POST" action="suivi.php?com='.$suiv2->id_commande.'&amp;id='.$suiv2->id_parent.'&amp;email='.$suiv2->email_parent.'"/>';
			for ($i=1; $i<=6; $i++) {
				if($suiv2->etat == $i)
				{
					echo '<td><div align="center"><input type="radio" class="test" name="suivi'.$suiv2->nom_parent.$suiv2->id_commande.'" value="'.$i.'" checked disabled></input></div></td>';
				}
				else
				{
					echo '<td><div align="center"><input type="radio" class="test" name="suivi'.$suiv2->nom_parent.$suiv2->id_commande.'" value="'.$i.'" disabled></input></div></td>';
				}

			}
			$nom = 'suivi'.$suiv2->nom_parent.$suiv2->id_commande;
			?>

			<td><div align="center"><input type="button" class="modif" value="Modifier" onClick="activeAccordeon()"></input></div></td>
			<td><div align="center"><input type="submit" class="save" name="enregistrer" value="Enregistrer" disabled></input></div></td>
			<input type="text" class="idcache" name="idcache" value="" hidden></input>
			<?php

			echo '<td><div align="center"><a class="fancy" value="commande'.$suiv2->nom_parent.'" href="commande.php?com='.$suiv2->id_commande.'&nom='.$suiv2->nom_parent.'">Etat de la commande</a></div></td>';		
			echo '</tr>';
			echo '</form>';
		}
	}

	if(isset($_POST['suivi']))
	{
		$etats = array("En cours de validation", "Validé", "Commande fournisseur", "En cours de livraison", "Livré", "Retiré et payé");
		message($_GET["email"], "Commande n° ".$_GET["com"], "Modification de l'état de la commande n° ".$_GET["com"]." : ".$etats[$_POST["suivi"]-1], 0, $_GET["id"]);

		$modifier = 'UPDATE Commande SET etat = '.$_POST['suivi'].' WHERE id_commande = '.$_GET['com'];
		$db->DB_query($modifier);

		print('<script type="text/javascript">location.href="suivi.php?nb='.$_POST['idcache'].'";</script>');
	}
	?>
	</table>
	<script type="text/javascript" src="../../../js/active_radio_bouton.js"></script>
	<script type="text/javascript" src="../../../js/chargement_page_suivi.js"></script>
	</div>
	<?php
}
?>

<form method="POST" action="suivi.php"><input type="submit" class="purger" name="purger" value="Purger"></input></form>



</div>

<?php

require_once('../inc/footer.inc.php');

?>