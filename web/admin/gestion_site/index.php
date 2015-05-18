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
				<td ><div align="right">Gestion du site</div></td>
			</tr>
		</table>
		<br>
		<br>

<?php

$db = new DB_connection();
$requete = 'SELECT jma FROM Date_limite';
$db->DB_query($requete);
while($req = $db->DB_object())
{
	$jma = $req->jma;
	$newDate = date("d-m-Y", strtotime($jma));
?>
		<table>
			<form method="get" action="index.php">
				<tr>
				<td><label class="gestion" for="jma">Date limite :</label></td>
				<td><input type="text" name="date" id="date" value="<?php echo $newDate; ?>" disabled/></td>
				<td><a href="gestion_site.php?gestion=jma"><input type="button" value="Modifier"></a></td>
				</tr>
				<tr>
			</form>
		</table>
<?php
}
?>

<?php

require_once('../inc/footer.inc.php');

?>