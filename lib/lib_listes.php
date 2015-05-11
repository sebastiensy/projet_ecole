<?php

// s'occupe de la mise en forme d'une ligne du formulaire
function mise_en_forme($idlist,$libelle,$prix)
{
	$tr = "<tr>";
	$qte = 1;
	if(isset($_SESSION["id_parent"]))
	{
		if(isset($_POST["id"]) && isset($_POST["qte"]))
		{
			if($idlist == $_POST["id"])
			{
				$tr = "<tr bgcolor=\"orange\">";
				$qte = $_POST["qte"];
			}
		}
	}
	echo $tr;
	?>
	   <td><div align="center"><a class="fancy2" href="liste.php?id=<?php echo $idlist; ?>"><?php echo $libelle; ?></a></div></td>
	   <td><?php echo $prix; ?> €</td>
	   <td><input type="number" size="2" min="1" max="20" name="qte" value="<?php echo $qte; ?>"/></td>
	   <td><input type="submit" value="Ajouter au panier"></td>
	   <td><input type="hidden" name="id" value="<?php echo $idlist; ?>"/></td>
   </tr>
	<?php
}

// s'occupe de la mise en forme de l'en-tête du formulaire
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
			$db = new DB_connection();
			$panier->addList($_POST["id"], $_POST["qte"]);
			$query = 'SELECT n.Libelle FROM Niveau n, Liste_niveau ln WHERE n.code = ln.niveau';
			$db->DB_query($query);
			echo "<span style=\"color:green\"><p><strong>La liste \"".$db->DB_object()->Libelle."\" a été ajouté au
			<a href=\"../panier\">panier</a> en ".$_POST["qte"]." exemplaires.</strong></p></span>";
		}
	}
	else
	{
		echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour ajouter des listes au panier.</strong></p></span>";
	}

	// placement de l'en-tête
	head();

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