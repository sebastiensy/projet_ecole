<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
require_once('../inc/header.inc.php');


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
				<td ><div align="right">Gestion du site</div></td>
			</tr>
		</table>
		<br>
		<br>

<?php

$db = new DB_connection();
$requete = 'SELECT jma FROM Date_limite';
$db->DB_query($requete);
if ($db->DB_count() == 0)
{
	$newDate = "";
}
else
{
	while($req = $db->DB_object())
	{
		$jma = $req->jma;
		$newDate = date("d/m/Y", strtotime($jma));
	}
}

?>
		<table>
			<form method="get" action="index.php">
				<tr>
				<td><label class="gestion" for="jma">Date limite des commandes : </label></td>
				<td><input type="text" name="date" id="date" value="<?php echo $newDate; ?>" disabled/></td>
				<td><a href="gestion_site.php?gestion=jma&amp;date=<?php echo $newDate;?>"><input type="button" value="Modifier"></a></td>
				</tr>
				<tr>
			</form>
		</table>
		<?php

if (isset($_GET["id"]) && isset($_GET["a"]))
{
	if ($_GET["a"] == "accorder")
	{
		$req = 'UPDATE Parent set droits_parents = 1 WHERE id_parent = "'.$db->quote($_GET["id"]).'"';
		$db->DB_query($req);	
	}
	else if ($_GET["a"] == "retirer")
	{
		$admin = 'SELECT id_parent FROM Parent WHERE droits_parents = 1';
		$db->DB_query($admin);

		if ($db->DB_count() > 1)  
		{
			$req = 'UPDATE Parent set droits_parents = 0 WHERE id_parent = "'.$db->quote($_GET["id"]).'"';
			$db->DB_query($req);
		}
	}
}
$requete = 'SELECT id_parent, nom_parent, email_parent, droits_parents FROM Parent ORDER BY droits_parents DESC';
$db->DB_query($requete);
if ($db->DB_count() > 0)
{
	?>
	<br><div align="left" style="text-decoration:underline">Gestion des droits</div>
	<p>Il est impossible de retirer les droits administrateur s'il n'y a qu'un seul administrateur.</p>
	<table width="900" align="center" class="data">
		<tr>
			<th width="90"><div align="center">Nom</div></th>
			<th width="90"><div align="center">Email</div></th>
			<th width="90"><div align="center">Droit</div></th>
			<th width="90"><div align="center">Action</div></th>
		</tr>
	<?php
	while($parent = $db->DB_object())
	{
		echo 
			"<tr>
				<td align=\"center\">".$parent->nom_parent."</td>
				<td align=\"center\">".$parent->email_parent."</td>";
		if ($parent->droits_parents == 0)
		{
			echo "<td align=\"center\">Parent</td>";
			echo "<td align=\"center\"><a href=\"index.php?id=".$parent->id_parent."&amp;a=accorder\"><img src=\"../../../img/admin.png\" title=\"Accorder les droits administrateur\"></a></tr>";
		}			
		else
		{
			echo "<td align=\"center\">Administrateur</td>";
			echo "<td align=\"center\"><a href=\"index.php?id=".$parent->id_parent."&amp;a=retirer\"><img src=\"../../../img/no_admin.png\" title=\"Retirer les droits administrateur\"></a></tr>";
		}
	}
	echo "</table>";

}
?>


<?php

require_once('../inc/footer.inc.php');

?>