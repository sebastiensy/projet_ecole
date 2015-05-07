<?php

// s'occupe de la mise en forme d'une ligne du formulaire
function mise_en_forme($idlist,$libelle,$prix)
{
	?>
	<tr>
	   <td><a href="?id=<?php echo $idlist; ?>"><?php echo $libelle; ?></a></td>
	   <td><?php echo $prix;?></td>
	   <td><input type="number" size="2" min="1" max="20" name="qte" value="1"/></td>
	   <td><input type="submit" value="Ajouter au panier"></td>
	   <td><input type="hidden" name="id" value="<?php echo $idlist; ?>"/></td>
   </tr>
	<?php
}

// s'occupe de la mise en forme de l'en tête du formulaire
function head()
{
	?>
	<form method="POST" action="">
		<table id="liste">
			<tr>
				<th>Niveau</th>
				<th>Prix forfaitaire</th>
				<th>Quantité</th>
				<th></th>
			</tr>
	<?php 
}

// mise en forme du footer du formulaire
function footer()
{
	?>
			<!-- <tr>
				<td colspan="2"></td>
				<td><input type="submit" class="" name="envoyer" value="Ajouter au panier"></td>
			</tr> -->
		</table>
	</form>
	<?php 
}

// affichage des listes
function affichage($panier)
{
	if(isset($_SESSION["id_parent"]))
	{
		if(isset($_POST["id"]) && isset($_POST["qte"]))
		{
			$panier->addList($_POST["id"], $_POST["qte"]);
		}
	}
	else
	{
		echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour ajouter des listes au panier.</strong></p></span>";
	}

	//placement de l entete
	head();

	// préparation de la requete 
	$requete = 'select ln.id_nivliste, ln.forfait, n.Libelle from Niveau n, Liste_niveau ln WHERE ln.niveau = n.code';

	// connexion a la base via la classe DB_connection
	$db = new DB_connection();

	// exécution de la requete
	$db->DB_query($requete);

	// mise en forme
	while(($ligne = $db->DB_object()) != null)
	{
		mise_en_forme($ligne->id_nivliste, $ligne->Libelle, $ligne->forfait);
	}
	footer();
}

?>