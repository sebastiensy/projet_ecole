<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');

?>

<html>
	<head>
		<title>Projet école</title>
		<!--<link rel="stylesheet" href="../../css/.css">-->
	</head>
	<body>


<?php

if (isset($_GET['id']))
{
	$id_msg = $_GET['id'];

	$requete = 'SELECT objet, message, jma FROM Message WHERE id_message = '.$id_msg;

	$db = new DB_connection();
	$db->DB_query($requete);

		
		while($msg = $db->DB_object())
		{
			?>

			<table width="500" align="left" class="data">
			<tr>
				<th width="90" ><div align="center">N° message</div></th>
				<td><?php echo $id_msg;?></td>
			</tr>
			<tr>
				<th width="90" ><div align="center">Objet</div></th>
				<?php echo "<td>".$msg->objet."</td>";?>
			</tr>
			<tr>
				<th width="90" ><div align="center">Date</div></th>
				<?php echo "<td>".$msg->jma."</td>";?>
			</tr>
			<tr>
				<th width="90" ><div align="center">Message</div></th>
				<?php echo "<td>".$msg->message."</td>";?>
			</tr>
			</table>

			<?php
			


		}

		
}
?>