<?php

require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<div id="page">

	<table width="900" align="center" class="entete">
		<tr>
			<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
		</tr>
	</table>

<?php

echo "<div align=\"center\" id=\"listen\">";

$db = new DB_connection();

if(isset($_POST["select"]))
{
	$query = 'INSERT INTO Liste_niveau(niveau, forfait) VALUES ("'.$_POST["select"].'", 0)';
	$db->DB_query($query);
}
else
{
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

</div>

<?php

require_once('../inc/footer.inc.php');

?>