<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

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
				<td ><div align="right">Messagerie</div></td>
			</tr>
		</table>
		<br>
		<br>

<?php

$db = new DB_connection();
$req = 'SELECT * FROM Message WHERE utilisateur = 1 ORDER BY id_message DESC';
$db->DB_query($req);

if($db->DB_count() > 0)
{
	?>
	<table width="900" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">N° message</div></th>
		<th width="90" ><div align="center">Expéditeur</div></th>
		<th width="90" ><div align="center">Objet</div></th>
		<th width="90" ><div align="center">Date</div></th>
		<th width="90" ><div align="center">Etat</div></th>
		<th width="90" ><div align="center">Actions</div></th>
	</tr>
	<?php
	$cpt = $db->DB_count();
	while($msg = $db->DB_object())
	{
		$var = ($msg->lu == 0) ? 'Non lu' : 'Lu';
		echo "<tr><td><div align='center'>".$cpt--."</div></td>";
		echo "<td><div align='center'>".$msg->email_parent."</div></td>";
		echo "<td><div align='center'>".$msg->objet."</div></td>";
		echo "<td><div align='center'>".date("d-m-Y", strtotime($msg->jma))."</div></td>";
		echo "<td><div align='center'>".$var."</div></td>";
		echo '<td><div align="center"><a class="fancyMsg" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'"><img title="Visualiser" src="../../../img/visu.png"></a>&nbsp;&nbsp;';
		?> <!-- <a href="suppr_message.php?id=<?php /*echo $msg->id_message;*/ ?>"><img title="Supprimer" src="../../../img/del.png"></a></div></td> -->
		<?php echo "<input type=\"button\" title=\"Supprimer\" onClick=setId(".$msg->id_message.") class=\"del btnOpenDialog\"/><div id=\"dialog-confirm\"></div></td>"; ?>
		<?php 
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type=\"hidden\" value=\"\" id=\"iden\">";
}
else
{
	echo "<p>Vous n'avez aucun message.</p>";
}

?>

<script>
$('.btnOpenDialog').click(fnOpenNormalDialog);
function callback(value) {
	var _id = document.getElementById("iden").value;
	if (value) {
		location.href = "suppr_message.php?id="+_id;
	} else {
	}
}
</script>

<?php

require_once('../inc/footer.inc.php');

?>