<?php

//session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

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

if(isset($_GET['gestion']))
	{
		?>
		<p>Veuillez saisir la date au format jj/mm/aaaa</p>
		<form method="post" action="gestion_site.php">
		<p><label class="gestion_site" for="jma">Date limite :</label><input type="text" id="date_limite" name="date_limite" value="<?php echo $_GET['date']; ?>" /></p>
		<input type="text" id="date_cache" name="date_cache" hidden/>
		<input type="submit" value="Enregistrer">
		</form>
	<?php
	}
	?>

<?php

if (isset($_POST['date_cache']))
{
	$db = new DB_connection();
	$modifier = 'UPDATE Date_limite SET jma = "'.$_POST['date_cache'].'"';
	$db->DB_query($modifier);
	header('Location: index.php');
}

?>	

<?php

require_once('../inc/footer.inc.php');

?>