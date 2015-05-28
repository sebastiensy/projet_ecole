<?php

// s'occupe de la mise en forme d'une ligne du formulaire
function mise_en_forme($idlist, $libelle, $prix, $now, $jma)
{
	$tr = "<tr>";
	$qte = 1;
	if(isset($_SESSION["id_parent"]))
	{
		if($now < $jma)
		{
			if(isset($_POST["id"]) && isset($_POST["qte"]))
			{
				if($idlist == $_POST["id"])
				{
					$tr = "<tr bgcolor=\"orange\">";
					//$qte = $_POST["qte"];
				}
			}
		}
	}
	echo $tr;
	?>
	   <td><div align="center"><?php echo $libelle; ?></div></td>
	   <td><?php echo number_format($prix, 2, ',', ' '); ?> €</td>
	   <td><input type="number" size="2" min="1" max="20" name="qte" value="<?php echo $qte; ?>"/></td>
	   <td><div align="center"><a class="fancy2" href="liste.php?id=<?php echo $idlist; ?>"><img title="Visualiser" src="../../img/visu.png"></a>&nbsp;&nbsp;
	   <input type="submit" title="Ajouter au panier" value="" class="ajPanier"></td>
	   <input type="hidden" name="id" value="<?php echo $idlist; ?>"/></div></td>
   </tr>
	<?php
}

// s'occupe de la mise en forme de l'en-tête du formulaire
function head()
{
	?>
		<div class="liste">
			<table>
				<tr>
					<td>Niveau</td>
					<td>Prix forfaitaire</td>
					<td>Quantité</td>
					<td>Actions</td>
				</tr>
	<?php 
}

// mise en forme du footer du formulaire
function footer()
{
	?>
		</table>
	</div>
	<?php 
}

// affichage des listes
function affichage($panier)
{
	$db = new DB_connection();
	$now = Date("Y-m-d");
	$jma = Date("Y-m-d");
	if(isset($_SESSION["id_parent"]))
	{
		$query = 'SELECT jma FROM Date_limite';
		$db->DB_query($query);
		if($db->DB_count() > 0)
		{
			if($date = $db->DB_object())
			{
				$now = new DateTime($now);
				$now = $now->format('Ymd');
				$jma = new DateTime($date->jma);
				$jma = $jma->format('Ymd');
			}
		}
		if($now < $jma)
		{
			if(isset($_POST["id"]) && isset($_POST["qte"]))
			{
				$panier->addList($_POST["id"], $_POST["qte"]);
				$query = 'SELECT n.Libelle FROM Niveau n, Liste_niveau ln WHERE n.code = ln.niveau AND ln.id_nivliste = "'.$_POST["id"].'"';
				$db->DB_query($query);
				echo "<span style=\"color:green\"><p><strong>La liste \"".$db->DB_object()->Libelle."\" a été ajouté au
				<a href=\"../panier\">panier</a> en ".$_POST["qte"]." exemplaires.</strong></p></span>";
			}
		}
		else
		{
			echo "<span style=\"color:red\"><p><strong>La date limite de commande est passée.</strong></p></span>";
		}
	}
	else
	{
		echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour ajouter des listes au panier.</strong></p></span>";
	}

	$requete = 'select ln.id_nivliste, ln.forfait, n.Libelle from Niveau n, Liste_niveau ln WHERE ln.niveau = n.code order by ln.niveau';

	// exécution de la requete
	$db->DB_query($requete);

	if($db->DB_count() > 0)
	{
		head();
	}
	else
	{
		echo "Il n'y a aucune liste.<br/>";
	}

	// mise en forme
	while(($ligne = $db->DB_object()) != null)
	{
		?>
		<form method="POST" action="">
			<?php
			mise_en_forme($ligne->id_nivliste, $ligne->Libelle, $ligne->forfait, $now, $jma);
			?>
		</form>
		<?php
	}

	if($db->DB_count() > 0)
	{
		footer();
	}
}

?>