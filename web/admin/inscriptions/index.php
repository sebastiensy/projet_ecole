<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<body>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<table width="900" align="center" class="entete">
			<tr>
				<td ><div align="right">Nouvelles inscriptions</div></td>
			</tr>
		</table>
		<br>
		<br>

<?php

$db = new DB_connection();

if(isset($_GET["id"]) && isset($_GET["a"]))
{
	if($_GET["a"] == "valider")
	{
			$query = 'UPDATE Parent set id_etat = 2 WHERE id_parent = "'.$_GET["id"].'"';
			$db->DB_query($query);
	}
	else if($_GET["a"] == "refuser")
	{
			$query = 'DELETE FROM Parent WHERE id_parent = "'.$_GET["id"].'"';
			$db->DB_query($query);
	}
}

$query = 'SELECT p.id_parent, p.nom_parent, p.email_parent, p.tel_parent, p.nb_enfants, p.id_etat FROM Parent p, Etat e WHERE p.id_etat = e.id_etat AND p.id_etat = 1';
$db->DB_query($query);

if($db->DB_count() > 0)
{
	?>
	<table width="900" align="center" class="data">
		<tr>
			<th width="90"><div align="center">Nom</div></th>
			<th width="90"><div align="center">Email</div></th>
			<th width="90"><div align="center">Téléphone</div></th>
			<th width="90"><div align="center">Enfants</div></th>
			<th width="90"><div align="center">Valider</div></th>
			<th width="90"><div align="center">Refuser</div></th>
		</tr>
	<?php
	while($inscription = $db->DB_object())
	{
		echo
		"<tr>
			<td align=\"center\">".$inscription->nom_parent."</td>
			<td align=\"center\">".$inscription->email_parent."</td>
			<td align=\"center\">".$inscription->tel_parent."</td>
			<td align=\"center\">".$inscription->nb_enfants."</td>
			<td align=\"center\"><a href=\"index.php?id=".$inscription->id_parent."&amp;a=valider\"><img src=\"../../../img/icon_OK.png\" title=\"Valider\"></a></td>
			<td align=\"center\"><a href=\"index.php?id=".$inscription->id_parent."&amp;a=refuser\"><img src=\"../../../img/del.png\" title=\"Refuser\"></a></td>
			<td align=\"center\"></td>
		</tr>";
	}
}
else
{
	echo "<p>Il n'y a pas de nouvelles inscriptions.</p>";
}

?>

<?php

require_once('../inc/footer.inc.php');

?>