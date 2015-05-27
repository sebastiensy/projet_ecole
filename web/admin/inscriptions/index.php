<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
require_once('../../../lib/lib_message.php');

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
		$query = 'UPDATE Parent set id_etat = 2 WHERE id_parent = "'.$_GET["id"].'"';
		$db->DB_query($query);

		$query = 'SELECT id_parent, nom_parent, email_parent FROM Parent WHERE id_parent = "'.$_GET["id"].'"';
		$db->DB_query($query);
		if($parent = $db->DB_object())
		{
			message($parent->email_parent, "Inscription", "Votre inscription a été validée !", 0, $parent->id_parent);

			/*$to = $parent->email_parent;
			$subject = "Rentrée facile - Validation de l'inscription";
			$message = "Bonjour ".$parent->nom_parent.",\r\n\r\n
			Votre inscription sur le site \"Rentrée facile\" a été validée. Nous vous remercions de votre confiance.\r\n\r\n
			Voici le lien pour accéder au site : ".$_SERVER['REQUEST_URI'];
			$headers = "From: no-reply@rentree-facile.fr" . "\r\n" .
			"Content-type: text/plain; charset=utf-8" . "\r\n";
			$succes = mail($to, $subject, $message, $headers);*/
		}
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
			<th width="90"><div align="center">Accepter</div></th>
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
			<td align=\"center\"><a href=\"index.php?id=".$inscription->id_parent."&amp;a=accepter\"><img src=\"../../../img/icon_OK.png\" title=\"Accepter\"></a></td>
			<td align=\"center\"><a href=\"index.php?id=".$inscription->id_parent."&amp;a=refuser\"><img src=\"../../../img/del.png\" title=\"Refuser\"></a></td>
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