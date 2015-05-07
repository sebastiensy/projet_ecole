<!--
INSERT INTO Parent (id_parent, nom_parent, mdp_parent, email_parent, tel_parent, nb_enfants, droits_parents) VALUES
('1', 'dupont', 'toto', 'test@test.com', '0123456789', 1, 0)
('2', 'toto', 'toto', 'test@test.com', '0123456789', 1, 0)
('3', 'titi', 'toto', 'test@test.com', '0123456789', 1, 0)
('4', 'azerty', 'toto', 'test@test.com', '0123456789', 1, 0)
('5', 'rrrr', 'toto', 'test@test.com', '0123456789', 1, 0)

INSERT INTO Commande (id_commande, date_cmd, etat, id_parent) VALUES
('1', '2014-11-20', 1, 1)
('2', '2014-11-01', 2, 2),
('3', '2014-12-01', 3, 3),
('4', '2015-01-01', 4, 4),
('5', '2014-11-01', 5, 5)
*/ -->
<?php 
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
?>

<div id="page">
	<table width="900" align="center" class="entete">
		<tr>
			<td ><div align="right">Suivi des Commandes</div></td>
		</tr>
	</table>
	<br>
	<br>
	<table width="900" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Parent</div></th>
		<th width="90" ><div align="center">En cours de validation</div></th>
		<th width="90" ><div align="center">Valide</div></th>
		<th width="90" ><div align="center">Commande fournisseur</div></th>
		<th width="90" ><div align="center">En cours de livraison</div></th>
		<th width="90" ><div align="center">Livre</div></th>
		<th width="90" ><div align="center">Retire et paye</div></th>
		<th width="90" ><div align="center"></div></th>
		<th width="90" ><div align="center"></div></th>
	</tr>

<?php
	
	$requete = 'SELECT p.nom_parent, c.etat, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent';

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
		echo "<tr><td><div align='center'>".$suiv->nom_parent."</div></td>";
		
		if ($commande != $suiv->id_commande)
		{		
			for ($i=1; $i<=6; $i++) {
				if($suiv->etat == $i)
				{
					echo '<td><div align="center"><input type="radio" name="suivi'.$suiv->nom_parent.'" value="'.$i.'" checked disabled></div></td>';
				}
				else
				{
					echo '<td><div align="center"><input type="radio" name="suivi'.$suiv->nom_parent.'" value="'.$i.'" disabled></div></td>';
				}

			}
			//echo '<td><input type="button" id="modifier'.$suiv->nom_parent.'" value="Modifier"></input></td>';
			//echo '<td><input type="submit" name="enregistrer'.$suiv->nom_parent.'" id="enregistrer'.$suiv->nom_parent.'" value="Enregistrer" disabled></input></td>';
			//echo '<td><a id="enregistrer'.$suiv->nom_parent.'" value="Enregistrer" href="change_etat.php"><img src="../../img/icon_OK.png" alt="ok"/></a></td>';
			
			echo '<td><div align="center"><a id="modifier'.$suiv->nom_parent.'" value="Modifier" href="suivi.php?com='.$suiv->id_commande.'">Modifier</a></div></td>';

			echo '<td><div align="center"><a class="fancy" value="commande'.$suiv->nom_parent.'" href="commande.php?com='.$suiv->id_commande.'&nom='.$suiv->nom_parent.'">Etat de la commande</a></div></td>';		
			echo "</tr>";
		}

		else
		{
			echo '<form method="POST" action="suivi.php?com='.$suiv->id_commande.'"/>';
			
			for ($i=1; $i<=6; $i++) {
				if($suiv->etat == $i)
					{
						echo '<td><div align="center"><input type="radio" name="suivi" class="suivi'.$suiv->nom_parent.'" value="'.$i.'" checked></div></td>';
					}
					else
					{
						echo '<td><div align="center"><input type="radio" name="suivi" class="suivi'.$suiv->nom_parent.'" value="'.$i.'"></div></td>';
					}
				}

				echo '<td><div align="center"><input type="submit" name="enregistrer" value="Enregistrer"></input></div></td>';
				echo '<td><div align="center"><a class="fancy" value="commande'.$suiv->nom_parent.'" href="commande.php?com='.$suiv->id_commande.'&nom='.$suiv->nom_parent.'">Etat de la commande</a></div></td>';		
				echo '</form>';


		}






	}

	if (isset($_POST['suivi']))
	{
		$modifier = 'UPDATE Commande SET etat = '.$_POST['suivi'].' WHERE id_commande = '.$_GET['com'];
		$db->DB_query($modifier);
		//header('Location: suivi.php');
		print('<script type="text/javascript">location.href="suivi.php";</script>');
	}





			/*echo "<script type='text/javascript'>";
			echo "$('#modifier".$suiv->nom_parent."').click(function(){
		        $('.suivi".$suiv->nom_parent."').prop('disabled',false);
		        $('#enregistrer".$suiv->nom_parent."').prop('disabled',false);
		    });";
			echo "</script>";*/

			/*echo "<script type='text/javascript'>";
			echo "$('#enregistrer".$suiv->nom_parent."').click(function(){
				var val;
				$('.suivi".$suiv->nom_parent.":checkbox:checked').each(function(){
	      		val = $(this).val();
	      		});
				
				alert(val);
				   
		        
		    });";
			echo "</script>";*/

			
			
			/*if (isset($_POST['enregistrer'.$suiv->nom_parent.'']))
			{	
				$etat = $_POST['suivi'.$suiv->nom_parent.''];
				$modifier = 'UPDATE Commande SET etat = '.$etat.' WHERE id_commande = '.$suiv->id_commande;
				$db->DB_query($modifier);
			
			}*/
		

	

	echo "</table>";
	

	
	$db->DB_done();
	
	
?>

<?php 
	require_once('../inc/footer.inc.php');
?>
