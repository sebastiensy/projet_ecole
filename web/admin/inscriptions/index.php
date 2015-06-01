<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
require_once('../../../lib/lib_message.php');
require_once('../../../lib/lib_mail.php');

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
	if($_GET["a"] == "accepter")
	{
		$query = 'UPDATE Parent set id_etat = 2 WHERE id_parent = "'.$db->quote($_GET["id"]).'"';
		$db->DB_query($query);

		$query = 'SELECT id_parent, nom_parent, email_parent FROM Parent WHERE id_parent = "'.$db->quote($_GET["id"]).'"';
		$db->DB_query($query);
		if($parent = $db->DB_object())
		{
			message($parent->email_parent, "Inscription", "Votre inscription a été validée !", 0, $parent->id_parent);

			$succes = envoiMail($parent->email_parent, "Rentrée facile - Validation de l'inscription", "Votre inscription sur le site \"Rentrée facile\" a été validée. Nous vous remercions de votre confiance.\r\n\r\n
			");

			if($succes)
			{
				echo "<span style=\"color:green\"><p><strong>Un mail d'acceptation a été envoyé à l'adresse ".$parent->email_parent.".</strong></p></span>";
			}
			else
			{
				echo "<span style=\"color:red\"><p><strong>L'envoi du mail d'acceptation à l'adresse ".$parent->email_parent." a échoué.</strong></p></span>";
			}
		}
	}
	else if($_GET["a"] == "refuser")
	{
		$query = 'SELECT p.id_parent FROM Parent p, Etat e WHERE p.id_etat = e.id_etat AND p.id_etat = 1 AND p.id_parent = "'.$db->quote($_GET["id"]).'"';
		$db->DB_query($query);
		if($db->DB_count() > 0)
		{
			$query = 'DELETE FROM Parent WHERE id_parent = "'.$db->quote($_GET["id"]).'"';
			$db->DB_query($query);
		}
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
			<th width="90"><div align="center">Actions</div></th>
		</tr>
	<?php
	while($inscription = $db->DB_object())
	{
		echo 
		"<tr>
			<td align=\"center\">".$inscription->nom_parent."</td>
			<td align=\"center\">".$inscription->email_parent."</td>
			<td align=\"center\">".$inscription->tel_parent."</td>
			<td align=\"center\">".$inscription->nb_enfants."</td>";
			//<td align=\"center\"><a href=\"index.php?id=".$inscription->id_parent."&amp;a=refuser\"><img src=\"../../../img/del.png\" title=\"Refuser\"></a></td>
			echo "<td align=\"center\"><a href=\"index.php?id=".$inscription->id_parent."&amp;a=accepter\"><img src=\"../../../img/icon_OK.png\" title=\"Accepter\"></a>&nbsp;&nbsp;
			<input type=\"button\" title=\"Supprimer\" onClick=setId(".$inscription->id_parent.") class=\"del btnOpenDialog\"/><div id=\"dialog-confirm\"></div></td>
		</tr>";
	}
	echo "<input type=\"hidden\" value=\"\" id=\"iden\">";
}
else
{
	echo "<p>Il n'y a pas de nouvelles inscriptions.</p>";
}

?>

<script>
$('.btnOpenDialog').click(fnOpenNormalDialog);
function callback(value) {
	var _id = document.getElementById("iden").value;
	if (value) {
		location.href = "index.php?id="+_id+"&a=refuser";
	} else {
	}
}
</script>

<?php

require_once('../inc/footer.inc.php');

?>