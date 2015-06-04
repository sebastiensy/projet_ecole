<?php

session_start();
require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');
require_once(LIB.'/lib_panier.class.php');
require_once(INC.'/droits.inc.php');
$dbs = new DB_connection();
$panier = new panier($dbs);

?>

<html>
	<head>
		<title>Rentrée Facile</title>
		<link rel="icon" type="image/png" href="../../img/icone.png"/>
		<link rel="stylesheet" href="../../css/style1.css">
		<script src="../../js/modliste.js"></script>
	</head>
	<body>
	<?php
	if(isset($_GET["id"]))
	{
		$db = new DB_connection();
		if(isset($_POST["enr"]))
		{
			if(isset($_SESSION['listeM']))
			{
				$ids = array_keys($_SESSION['listeM']);
				if(!empty($ids))
				{
					$query = 'SELECT id_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
					$db->DB_query($query);
					if($db->DB_count() > 0)
					{
						while($mat = $db->DB_object())
						{
							$panier->add($mat->id_mat, $_SESSION["listeM"][$mat->id_mat]);
						}
						echo "<span style=\"color:green; font-size:13pt\"><p><strong>Les fournitures indiquées ont été ajoutées au panier&nbsp;</strong><img src=\"../../img/icon_OK.png\"></p></span>";
					}
				}
				unset($_SESSION["listeM"]);
					echo "</body>
				</html>";
				exit;
			}
		}

		if(isset($_SESSION["listeM"]))
		{
			unset($_SESSION["listeM"]);
		}

		$query2 = 'SELECT * FROM Compose c, Materiel m, Liste_niveau ln, Niveau n WHERE c.id_mat = m.id_mat AND c.id_nivliste = ln.id_nivliste AND n.code = ln.niveau AND ln.id_nivliste = '.$db->quote($_GET["id"]);
		$db->DB_query($query2);
		if($db->DB_count() > 0)
		{
			while($mat = $db->DB_object())
			{
				$_SESSION["listeM"][$mat->id_mat] = $mat->qte_scat;
			}
		}

		?>
		<div id="listeM"></div>

		<form method="post" action="">
			<input type="submit" title="Ajouter au panier" name="enr" value="Ajouter au panier">
		</form>
		<?php
	}
	?>

	<script>
	window.onload = function()
	{
		afficheListe();
	}
	</script>

	</body>
</html>