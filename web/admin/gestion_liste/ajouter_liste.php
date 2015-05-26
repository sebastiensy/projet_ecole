<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
require_once('../../../inc/redirect.inc.php');

?>

<body onLoad="tabFournitures()">

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<table width="900" align="center" class="entete">
			<tr>
				<?php
				$db = new DB_connection();
				if(isset($_POST["select"]))
				{
					$query = 'SELECT Libelle FROM Niveau WHERE code = "'.$_POST["select"].'"';
					$db->DB_query($query);
					if($niv = $db->DB_object())
					{
						?>
						<td><div align="right">Ajouter Une Nouvelle Liste (<?php echo $niv->Libelle; ?>)</div></td>
						<?php
					}
					else
					{
						?>
						<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
						<?php
					}
				}
				else
				{
					?>
					<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
					<?php
				}
				?>
			</tr>
		</table>
		<br>
		<br>

<?php

if(isset($_POST["enrListe"]))
{
	if(isset($_SESSION['four']))
	{
		$ids = array_keys($_SESSION['four']);
		if(!empty($ids))
		{
			$query = 'SELECT id_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
			$db->DB_query($query);
			$prix = 0;
			if($db->DB_count() > 0)
			{
				$query = 'INSERT INTO Compose (qte_scat, id_mat, id_nivliste) VALUES';
				while($mat = $db->DB_object())
				{
					$query .= '("'.$_SESSION["four"][$mat->id_mat].'", "'.$mat->id_mat.'", "'.$_POST["idniv"].'"),';
					$prix += $mat->prix_mat * $_SESSION["four"][$mat->id_mat];
				}
				//$prix = $prix * (100-$_POST["reduc"]) / 100;
				$prix = $_POST["reduc"];
				$query = substr($query, 0, -1);
				$db->DB_query($query);
				$query = 'UPDATE Liste_niveau SET forfait = "'.$prix.'" WHERE id_nivliste = "'.$_POST["idniv"].'"';
				$db->DB_query($query);
				echo "<span style=\"color:green\"><p><strong>La liste a été ajoutée.</strong></p></span>";
				echo "Retourner sur la <a href=\"../gestion_liste\">gestion des listes</a>";
				unset($_SESSION["four"]);
			}
		}
		else
		{
			echo "<span style=\"color:red\"><p><strong>Aucun article n'a été ajouté à la liste.</strong></p></span>";
			echo "Retourner sur la <a href=\"../gestion_liste\">gestion des listes</a>";
		}
	}
	else
	{
		echo "<span style=\"color:red\"><p><strong>Aucun article n'a été ajouté à la liste.</strong></p></span>";
		echo "Retourner sur la <a href=\"../gestion_liste\">gestion des listes</a>";
	}
}
else if(isset($_POST["select"]))
{
	$query = 'INSERT INTO Liste_niveau(niveau, forfait) VALUES ("'.$_POST["select"].'", 0)';
	$db->DB_query($query);
	$idniv = $db->DB_id();

	$query = "SELECT DISTINCT(categorie) FROM Sous_categorie";
	$db->DB_query($query);

	?>

	<div id="tabg">

			<?php

			if($db->DB_count() > 0)
			{
				?>
				<p><b><u>Sélectionner une catégorie :</u></b></p>
				<select id="Fid" name="selectC" onChange="tabFournitures()"/>
				<?php
				while($rub = $db->DB_object())
				{
					echo "<option value=".urlencode($rub->categorie).">".$rub->categorie."</option>";
				}
				?>
				</select>
				<?php
			}

			?>

		<p>
			<div id="resultat"></div>
		</p>
	</div>

	<div id="tabd">

		<form method="post" action="">
		<input type="hidden" name="idniv" value="<?php echo $idniv; ?>">
		<p><input type="submit" name="enrListe" value="Enregistrer">&nbsp;&nbsp;Forfait : <input type="number" id ="reduc" name="reduc" value="0" size="1" min="0"> €

		<p>
			<div id="resultat2"></div>
		</p>

		</form>

	</div>

	<?php
}
else
{
	if(isset($_SESSION["four"]))
	{
		unset($_SESSION["four"]);
	}

	$query = 'SELECT * FROM Niveau WHERE code not in (select distinct(niveau) FROM Liste_niveau)';
	$db->DB_query($query);

	if($db->DB_count() > 0)
	{
		echo "<div align=\"center\">";
		echo "<form method=\"post\" action=\"\">";
		echo "<fieldset align=\"center\" class=\"gen\">";
			echo "<legend>Niveau</legend>";
			echo "<select name=\"select\">";
			while($liste = $db->DB_object())
			{
				echo "<option value=".$liste->code.">".$liste->Libelle."</option>";
			}
			echo "</select>";
		echo "</fieldset>";
		echo "<br/><input type=\"submit\" value=\"Valider\">";
		echo "</div>";
		echo "</form>";
	}
	else
	{
		echo "<p><strong>Il y a déjà une liste par niveau.</strong></p>";
		echo "Retourner sur la <a href=\"../gestion_liste\">gestion des listes</a>";
	}
}

$db->DB_done();

?>

<script type="text/javascript" src="../../../js/ajax.js"></script>

<?php

require_once('../inc/footer.inc.php');

?>