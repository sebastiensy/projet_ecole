<?php

require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<div id="page">
	<table width="900" align="center" class="entete">
		<tr>
			<td ><div align="right">Les Listes</div></td>
		</tr>
	</table>
	<br/><br/><br/><br/>

	<table width="900" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Niveau-Classe</div></th>
		<th width="50" ><div align="center">Prix(forfait)</div></th>
		<th width="50" ><div align="center">Modifier</div></th>
		<th width="20" ><div align="center">Supprimer</div></th>
	</tr>

<?php 

function get_niveau($code)
{
	$req="select libelle from Niveau where code='".$code."'";
	$db = new DB_connection();
	$db->DB_query($req);
	if($ligne=$db->DB_object())
	{
		return $ligne->libelle;
	}
}

$db = new DB_connection();
$req="select * from Liste_niveau";
$db->DB_query($req);
while($ligne=$db->DB_object())
{
	?>
	<tr>
		<td width="90" ><div align="center"><?php echo get_niveau($ligne->niveau);?></div></td>
		<td width="50" ><div align="center"><?php echo $ligne->forfait;?></div></td>
		<td width="50" ><div align="center"><a href="modif_liste.php?id=<?php echo $ligne->id_nivliste;?>"> Modifier </a></div></td>
		<td width="50" ><div align="center"><a href="del_liste.php?id=<?php echo $ligne->id_nivliste;?>"><img src="../../../img/del.png"></a></div></td>
	</tr>
	<?php
}

?>

</table>
<br/>
<table width="900" align="center">
	<tr>
		<!-- <td><div align="right"><a href="aliste.php?p=1" class="myButton">Ajouter Une liste</a></div></td> -->
		<td><div align="right"><a href="new_aliste.php" class="myButton">Ajouter Une liste</a></div></td>
	</tr>
</table>

<?php

require_once('../inc/footer.inc.php');

?>