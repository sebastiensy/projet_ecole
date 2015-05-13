<?php

require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>
	
	<div id="page">

		<table width="900" align="center" class="entete">
			<tr>
				<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
			</tr>
		</table>

<?php

$db = new DB_connection();

if(isset($_POST["select"]))
{
	$query = 'INSERT INTO Liste_niveau(niveau, forfait) VALUES ("'.$_POST["select"].'", 0)';
	$db->DB_query($query);

	?>

	<div id="tabg">
		AAAAAAAAAAAAAAAA
	</div>

	<div id="tabd">
		BBBBBBBBBBBBBBBB
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

?>

<?php

require_once('../inc/footer.inc.php');

?>