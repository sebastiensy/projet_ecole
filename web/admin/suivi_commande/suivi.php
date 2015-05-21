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

		<?php
		if(!isset($_SESSION['droits']))
		{
			header("Location: ../../index.php");
		}
		else
		{
			if($_SESSION['droits'] != 1)
			{
				header("Location: ../../index.php");
			}
		}
		?>

		<table width="900" align="center" class="entete">
			<tr>
				<td ><div align="right">Suivi des Commandes</div></td>
			</tr>
		</table>

		<div id="accordion-resizer">

<?php

$requete = 'SELECT p.id_parent, p.nom_parent, c.etat, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND c.etat > 0 GROUP BY p.id_parent';

$db = new DB_connection();
$db->DB_query($requete);


if (isset($_GET['com']))
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
			<th width="90" ><div align="center">Valide</div></th>
			<th width="90" ><div align="center">Commande fournisseur</div></th>
			<th width="90" ><div align="center">En cours de livraison</div></th>
			<th width="90" ><div align="center">Livre</div></th>
			<th width="90" ><div align="center">Retire et paye</div></th>
			<th width="90" ><div align="center"></div></th>
			<th width="90" ><div align="center"></div></th>
			<th width="90" ><div align="center"></div></th>
		</tr>
	<?php
	$requete2 = 'SELECT p.id_parent, p.nom_parent, c.etat, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND c.etat > 0 AND p.id_parent = '.$suiv->id_parent.'';
	$db2 = new DB_connection();
	$db2->DB_query($requete2);
	$cpt = 1;
	while($suiv2 = $db2->DB_object())
	{
	?>
		<?php
			echo "<tr><td><div align='center'>".$cpt."</div></td>";
			$cpt++;
			if ($commande != $suiv2->id_commande)
			{
			echo '<form method="POST" action="suivi.php?com='.$suiv2->id_commande.'&id='.$suiv2->id_parent.'"/>';
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
			
			<td><div align="center"><input type="button" class="modif" value="Modifier"></input></div></td>
			<td><div align="center"><input type="submit" class="save" name="enregistrer" value="Enregistrer" disabled></input></div></td>
			<?php

			echo '<td><div align="center"><a class="fancy" value="commande'.$suiv2->nom_parent.'" href="commande.php?com='.$suiv2->id_commande.'&nom='.$suiv2->nom_parent.'">Etat de la commande</a></div></td>';		
			echo '</tr>';
			echo '</form>';
		}

		if (isset($_POST['suivi']))
		{
		$modifier = 'UPDATE Commande SET etat = '.$_POST['suivi'].' WHERE id_commande = '.$_GET['com'];
		$var1 = $_GET['id'] - 1;
		$db->DB_query($modifier);
		print('<script type="text/javascript">location.href="suivi.php?nb='.$var1.'";</script>');
		}

		?>
	
	<?php 
	}
	?>
	</table>
	<script type="text/javascript" src="../../../js/active_radio_bouton.js"></script>
	<script type="text/javascript" src="../../../js/chargement_page_suivi.js"></script>
	</div>
	<?php
}
?>
</div>

<?php

require_once('../inc/footer.inc.php');

?>