<?php

session_start();
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
				<td ><div align="right">Messagerie</div></td>
			</tr>
		</table>
		<br>
		<br>
		<table width="900" align="center" class="data">
			<tr>
				<th width="90" ><div align="center">N° message</div></th>
				<th width="90" ><div align="center">Expéditeur</div></th>
				<th width="90" ><div align="center">Objet</div></th>
				<th width="90" ><div align="center">Date</div></th>
				<th width="90" ><div align="center">Etat</div></th>
				<th width="90" ><div align="center"></div></th>
				<th width="90" ><div align="center"></div></th>
			</tr>

<?php 

$db = new DB_connection();
$req = 'SELECT * FROM Message ORDER BY id_message ASC';
$db->DB_query($req);

while($msg = $db->DB_object())
{
	if ($msg->lu == 0)
	{
		echo "<tr><td><div align='center'>".$msg->id_message."</div></td>";
		echo "<td><div align='center'>".$msg->email_parent."</div></td>";
		echo "<td><div align='center'>".$msg->objet."</div></td>";
		echo "<td><div align='center'>".$msg->jma."</div></td>";
		echo "<td><div align='center'>Non lu</div></td>";
		echo '<td><div align="center"><a class="fancy" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'">Afficher</a></div></td>';
		?> <td><div align="center"><a href="suppr_message.php?id=<?php echo $msg->id_message;?>"><img src="../../../img/del.png"> </a></div></td>

		<?php 
		echo "</tr>";
	}
	else
	{
		echo "<tr><td><div align='center'>".$msg->id_message."</div></td>";
		echo "<td><div align='center'>".$msg->email_parent."</div></td>";
		echo "<td><div align='center'>".$msg->objet."</div></td>";
		echo "<td><div align='center'>".$msg->jma."</div></td>";
		echo "<td><div align='center'>Lu</div></td>";
		echo '<td><div align="center"><a class="fancy" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'">Afficher</a></div></td>';
		?> <td><div align="center"><a href="suppr_message.php?id=<?php echo $msg->id_message;?>"><img src="../../../img/del.png"> </a></div></td>

		<?php 
		echo "</tr>";
	}
	
}

?>

<?php

require_once('../inc/footer.inc.php');

?>