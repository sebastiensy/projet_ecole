<?php

session_start();
require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');
require_once(INC.'/droits.inc.php');

?>

<html>
	<head>
		<title>Rentr�e Facile</title>
		<link rel="icon" type="image/png" href="../../img/icone.png"/>
		<link rel="stylesheet" href="../../css/style1.css">
	</head>
	<body>

<?php

if(isset($_GET['id']))
{
	$db = new DB_connection();

	$id_msg = $db->quote($_GET['id']);

	$requete2 = 'UPDATE Message set lu = 1 WHERE id_message = \''.$id_msg.'\'';

	$requete = 'SELECT m.id_parent, m.objet, m.message, m.jma FROM Message m, Parent p WHERE utilisateur = 0 AND m.id_parent = p.id_parent AND m.id_parent = "'.$_SESSION["id_parent"].'" AND id_message = \''.$id_msg.'\'';

	$db->DB_query($requete);

	if ($db->DB_count() > 0)
	{
		while($msg = $db->DB_object())
		{
			?>
			<table width="500" align="left" class="data">
			<tr>
				<th width="90" ><div align="right">Objet : </div></th>
				<?php echo "<td>".$msg->objet."</td>";?>
			</tr>
			<tr>
				<th width="90" ><div align="right">Date : </div></th>
				<?php echo "<td>".date("d-m-Y", strtotime($msg->jma))."</td>";?>
			</tr>
			<tr>
				<th width="90" ><div align="right">Message : </div></th>
				<?php echo "<td>".$msg->message."</td>";?>
			</tr>
			</table>
			<?php
		}
		$db->DB_query($requete2);
		$db->DB_done();
	}
}

?>

	</body>
</html>