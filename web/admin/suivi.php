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

	$requete = 'SELECT p.nom_parent, c.etat FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent';

	$co = mysqli_connect('localhost', 'root', '', 'projet_ecole'); 
	$res = mysqli_query($co, $requete);

	echo 'Suivi des commandes';
	

	while($suiv = mysqli_fetch_object($res))
	{
		/*echo "<table>
				<tr>
					<td>".$suiv->nom_parent."</td>
					<td>".$suiv->etat."</td>
			  	</tr>
			  </table>";*/
		echo '<br>';
		echo $suiv->nom_parent;
		echo '<INPUT type="radio" name="suivi" value=.$suiv->etat> en cours de validation
		  <INPUT type="radio" name="suivi" value="2"> valide
		  <INPUT type="radio" name="suivi" value="3"> commande fournisseur
		  <INPUT type="radio" name="suivi" value="4"> en cours de livraison 
		  <INPUT type="radio" name="suivi" value="5"> livre';

		switch ($suiv->etat) {
			case '1':
				
				break;

			case '2':
				# code...
				break;

			case '3':
				# code...
				break;

			case '4':
				# code...
				break;

			case '5':
				# code...
				break;
			
			default:
				# code...
				break;
		}

		while () {
			# code...
		}
	
		
		echo '<br>';



	}



?>