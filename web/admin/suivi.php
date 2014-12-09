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

<body>

<div id="banner">
</div>

<div id="page">
<?php

	$recharge = false;

	require_once('../../inc/data.inc.php');

	$requete = 'SELECT p.nom_parent, c.etat, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent';

	$db = new DB_connection();
	$db->DB_query($requete);

	echo 'Suivi des commandes';

	echo "<form method='POST' action='suivi.php'>";
	echo "<table>
			<tr>
				<th>Parent</th>
				<th>En cours de validation</th>
				<th>Valide</th>
				<th>Commande fournisseur</th>
				<th>En cours de livraison</th>
				<th>Livre</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>";

	
	while($suiv = $db->DB_object())
	{
		echo "<tr><td>".$suiv->nom_parent."</td>";
				
		for ($i=1; $i<=5; $i++) {
			if($suiv->etat == $i)
			{
				echo '<td><input type="radio" name="suivi'.$suiv->nom_parent.'" class="suivi'.$suiv->nom_parent.'" value="'.$i.'" checked disabled></td>';
			}
			else
			{
				echo '<td><input type="radio" name="suivi'.$suiv->nom_parent.'" class="suivi'.$suiv->nom_parent.'" value="'.$i.'" disabled></td>';
			}

		}
		echo '<td><input type="button" id="modifier'.$suiv->nom_parent.'" value="Modifier"></input></td>';
		echo '<td><input type="submit" name="enregistrer'.$suiv->nom_parent.'" id="enregistrer'.$suiv->nom_parent.'" value="Enregistrer" disabled></input></td>';
		//echo '<td><a id="enregistrer'.$suiv->nom_parent.'" value="Enregistrer" href="change_etat.php"><img src="../../img/icon_OK.png" alt="ok"/></a></td>';
		echo '<td><a id="fancy" value="commande'.$suiv->nom_parent.'" href="commande.php\?com='.$suiv->id_commande.'&nom='.$suiv->nom_parent.'">Etat de la commande</a></td>';		
		echo "</tr>";

		echo "<script type='text/javascript'>";
		echo "$('#modifier".$suiv->nom_parent."').click(function(){
	        $('.suivi".$suiv->nom_parent."').prop('disabled',false);
	        $('#enregistrer".$suiv->nom_parent."').prop('disabled',false);
	    });";
		echo "</script>";

		/*echo "<script type='text/javascript'>";
		echo "$('#enregistrer".$suiv->nom_parent."').click(function(){
			var val;
			$('.suivi".$suiv->nom_parent.":checkbox:checked').each(function(){
      		val = $(this).val();
      		});
			
			alert(val);
			   
	        
	    });";
		echo "</script>";*/

		
		
		if (isset($_POST['enregistrer'.$suiv->nom_parent.'']))
		{	
			$etat = $_POST['suivi'.$suiv->nom_parent.''];
			$modifier = 'UPDATE Commande SET etat = '.$etat.' WHERE id_commande = '.$suiv->id_commande;
			$db->DB_query($modifier);
		
		}
		

	}

	echo "</table>";
	echo "</form>";

	
	$db->DB_done();
?>

</div>
</body>
</html>
