<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
require_once('../../../inc/redirect.inc.php');

?>

<script type="text/javascript" src="../../../js/ajax.js"></script>

<body>

<script type="text/javascript">
window.onload = function()
{
	//tabFournitures();
	afficListe();
}
</script>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<table width="900" align="center" class="entete">
			<tr>
				<?php
				$db = new DB_connection();
				if(isset($_GET["id"]))
				{
					$query = 'SELECT n.Libelle, ln.id_nivliste FROM Niveau n, Liste_niveau ln WHERE ln.niveau = n.code AND ln.id_nivliste = "'.$_GET["id"].'"';
					$db->DB_query($query);
					if($niv = $db->DB_object())
					{
						echo "<td><div align=\"right\">Modification de la liste (".$niv->Libelle.")</div></td>";
						$idniv = $niv->id_nivliste;
					}
				}
				?>
			</tr>
		</table>
		<br>
		<br>

<?php

if(isset($_POST["enrListe"]))
{
	if(isset($_SESSION['four']))
	{
		$query = 'DELETE FROM Compose WHERE id_nivliste = "'.$_POST["idniv"].'"';
		$db->DB_query($query);
		$query = 'UPDATE Liste_niveau SET forfait = 0 WHERE id_nivliste = "'.$_POST["idniv"].'"';
		$db->DB_query($query);
		$ids = array_keys($_SESSION['four']);
		if(!empty($ids))
		{
			$query = 'SELECT id_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
			$db->DB_query($query);
			$prix = 0;
			if($db->DB_count() > 0)
			{
				$query = 'INSERT INTO Compose (qte_scat, id_mat, id_nivliste) VALUES';
				while($mat = $db->DB_object())
				{
					$query .= '("'.$_SESSION["four"][$mat->id_mat].'", "'.$mat->id_mat.'", "'.$_POST["idniv"].'"),';
					$prix += $mat->prix_mat * $_SESSION["four"][$mat->id_mat];
				}
				$prix = $prix * (100-$_POST["reduc"]) / 100;
				$query = substr($query, 0, -1);
				//$query .= ' ON DUPLICATE KEY UPDATE qte_scat=VALUES(qte_scat)';
				$db->DB_query($query);
				$query = 'UPDATE Liste_niveau SET forfait = "'.$prix.'" WHERE id_nivliste = "'.$_POST["idniv"].'"';
				$db->DB_query($query);
			}
		}
		unset($_SESSION["four"]);
	}
	echo "<span style=\"color:green\"><p><strong>La liste a été modifiée.</strong></p></span>";
	echo "Retourner sur la <a href=\"../gestion_liste\">gestion des listes</a>";
	require_once('../inc/footer.inc.php');
	exit;
}

if(isset($_SESSION["four"]))
{
	unset($_SESSION["four"]);
}

$query2 = 'SELECT * FROM Compose c, Materiel m, Liste_niveau ln, Niveau n WHERE c.id_mat = m.id_mat AND c.id_nivliste = ln.id_nivliste AND n.code = ln.niveau AND ln.id_nivliste = '.$_GET["id"];
$db->DB_query($query2);
if($db->DB_count() > 0)
{
	while($mat = $db->DB_object())
	{
		$_SESSION["four"][$mat->id_mat] = $mat->qte_scat;
	}
}

$query = "SELECT DISTINCT(categorie) FROM Sous_categorie";
$db->DB_query($query);

?>

<div id="tabg">

		<?php

		if($db->DB_count() > 0)
		{
			?>
			<p><b><u>Sélectionner une catégorie :</u></b></p>
			<select id="Fid" name="selectC" onChange="tabFournitures()"/>
			<?php
			while($rub = $db->DB_object())
			{
				echo "<option value=".urlencode($rub->categorie).">".$rub->categorie."</option>";
			}
			?>
			</select>
			<?php
		}

		?>

	<p>
		<div id="resultat"></div>
	</p>
</div>

<div id="tabd">

	<form method="post" action="">
	<input type="hidden" name="idniv" value="<?php echo $idniv; ?>">
	<p><input type="submit" name="enrListe" value="Enregistrer">&nbsp;&nbsp;Remise : <input type="number" id ="reduc" onChange="" name="reduc" value="0" size="1" min="0" max="100"> % 
	<!-- &nbsp;Prix : <span id="resultat3">0,00</span> €</p> -->

	<p>
		<div id="resultat2"></div>
	</p>

	</form>

</div>

<?php

$db->DB_done();

?>

<?php

require_once('../inc/footer.inc.php');

?>