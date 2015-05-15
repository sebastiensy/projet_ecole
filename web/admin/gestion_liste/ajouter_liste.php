<?php

require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

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

<?php

if(isset($_POST["select"]))
{
	$query = 'INSERT INTO Liste_niveau(niveau, forfait) VALUES ("'.$_POST["select"].'", 0)';
	$db->DB_query($query);

	$query = "SELECT DISTINCT(categorie) FROM Sous_categorie";
	$db->DB_query($query);

	?>

	<div id="tabg">

			<?php

			if($db->DB_count() > 0)
			{
				?>
				<p><b><u>Sélectionner une rubrique :</u></b></p>
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
		<p><input type="submit" name="enrListe" value="Enregistrer"></p>

		<p>
			<div id="resultat2"></div>
		</p>

		</form>

	</div>

	<?php
}
else
{
	echo "<div align=\"center\">";
	$query = 'SELECT * FROM Niveau WHERE code not in (select distinct(niveau) FROM Liste_niveau)';
	$db->DB_query($query);

	if($db->DB_count() > 0)
	{
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
}

$db->DB_done();

?>

<?php

require_once('../inc/footer.inc.php');

?>