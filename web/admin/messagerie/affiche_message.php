<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<html>
	<head>
		<title>Interface Administrateur</title>
		<link rel="icon" type="image/png" href="../../../img/icone.png"/>
		<link rel="stylesheet" href="../../../css/style1.css">
	</head>
	<body>

<?php

if (isset($_GET['id']))
{
	$db = new DB_connection();

	$id_msg = $db->quote($_GET['id']);

	$requete2 = 'UPDATE Message set lu = 1 WHERE id_message = '.$id_msg;

	$requete = 'SELECT email_parent, objet, message, jma FROM Message WHERE id_message = '.$id_msg;

	$db->DB_query($requete);

	while($msg = $db->DB_object())
	{
		?>
		<table width="800" align="left" class="data">
		<!-- <tr>
			<th width="90" ><div align="center">N° message</div></th>
			<td><?php /*echo $id_msg;*/ ?></td>
		</tr> -->
		<tr>
			<th width="90" ><div align="center">Expediteur</div></th>
			<?php echo "<td>".$msg->email_parent."</td>";?>
		</tr>
		<tr>
			<th width="90" ><div align="center">Objet</div></th>
			<?php echo "<td>".$msg->objet."</td>";?>
		</tr>
		<tr>
			<th width="90" ><div align="center">Date</div></th>
			<?php echo "<td>".date("d-m-Y", strtotime($msg->jma))."</td>";?>
		</tr>
		<tr>
			<th width="90" ><div align="center">Message</div></th>
			<?php echo "<td>".$msg->message."</td>";?>
		</tr>
		</table>
		<?php
	}
	$db->DB_query($requete2);
	$db->DB_done();
}
?>

	</body>
</html>