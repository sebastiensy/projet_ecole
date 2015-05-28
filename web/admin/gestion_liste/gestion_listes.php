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
if($db->DB_count() > 0)
{
	?>
	<table width="900" align="center" class="data">
	<tr>
		<th width="90" ><div align="center">Niveau</div></th>
		<th width="50" ><div align="center">Prix (forfait)</div></th>
		<th width="50" ><div align="center">Actions</div></th>
	</tr>
	<?php
	while($ligne=$db->DB_object())
	{
		?>
		<tr>
			<td width="90"><div align="center"><?php echo get_niveau($ligne->niveau); ?></div></td>
			<td width="50"><div align="center"><?php echo number_format($ligne->forfait, 2, ',', ' '); ?> €</div></td>
			<td width="90"><div align="center"><a class="fancy" href="liste.php?id=<?php echo $ligne->id_nivliste; ?>"><img title="Visualiser" src="../../../img/visu.png"></a>&nbsp;&nbsp;
			<a href="modif_liste.php?id=<?php echo $ligne->id_nivliste; ?>"><img title="Modifier" src="../../../img/modif.png"></a>&nbsp;&nbsp;
			<!-- <a href="del_liste.php?id=<?php /*echo $ligne->id_nivliste;*/ ?>"><img title="Supprimer" src="../../../img/del.png"></a></div></td> -->
			<?php echo "<input type=\"button\" title=\"Supprimer\" onClick=setId(".$ligne->id_nivliste.") class=\"del btnOpenDialog\"/><div id=\"dialog-confirm\"></div></td>"; ?>
		</tr>
		<?php
	}
}
else
{
	echo "<p>Il n'y a aucune liste.</p>";
}

?>

<input type="hidden" value="" id="iden">

</table>
<br/>
<table width="900" align="center">
	<tr>
		<td><div align="right"><a href="ajouter_liste.php" class="myButton">Ajouter Une liste</a></div></td>
	</tr>
</table>

<script>
$('.btnOpenDialog').click(fnOpenNormalDialog);
function callback(value) {
	var _id = document.getElementById("iden").value;
	if (value) {
		location.href = "del_liste.php?id="+_id;
	} else {
	}
}
</script>

<?php

require_once('../inc/footer.inc.php');

?>