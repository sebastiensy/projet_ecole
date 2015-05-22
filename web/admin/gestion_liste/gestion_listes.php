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
				<td ><div align="right">Les Listes</div></td>
			</tr>
		</table>
		<br/><br/>

		<table width="900" align="center" class="data">
		<tr>
			<th width="90" ><div align="center">Niveau</div></th>
			<th width="50" ><div align="center">Prix (forfait)</div></th>
			<th width="50" ><div align="center">Modifier</div></th>
			<th width="20" ><div align="center">Supprimer</div></th>
		</tr>

<?php 

function get_niveau($code)
{
	$req="select libelle from Niveau where code = '".$code."'";
	$db = new DB_connection();
	$db->DB_query($req);
	if($ligne=$db->DB_object())
	{
		return $ligne->libelle;
	}
}

$db = new DB_connection();
$req="select * from Liste_niveau order by niveau";
$db->DB_query($req);
while($ligne=$db->DB_object())
{
	?>
	<tr>
		<td width="90" ><div align="center"><?php echo get_niveau($ligne->niveau); ?></div></td>
		<td width="50" ><div align="center"><?php echo number_format($ligne->forfait, 2, ',', ' '); ?> €</div></td>
		<td width="50" ><div align="center"><a href="modif_liste.php?id=<?php echo $ligne->id_nivliste; ?>"> Modifier </a></div></td>
		<td width="50" ><div align="center"><a href="del_liste.php?id=<?php echo $ligne->id_nivliste; ?>"><img title="Supprimer" src="../../../img/del.png"></a></div></td>
	</tr>
	<?php
}

?>

</table>
<br/>
<table width="900" align="center">
	<tr>
		<td><div align="right"><a href="ajouter_liste.php" class="myButton">Ajouter Une liste</a></div></td>
	</tr>
</table>

<?php

require_once('../inc/footer.inc.php');

?>