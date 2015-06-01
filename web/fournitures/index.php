<?php

session_start();
require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_fournitures.php');

?>

<body onload="afficheWorkflow()" id="back">

	<div id="banner">
	</div>

	<div class="menu">

		<div id="connexion">
			<?php
				require_once("../connexion/login.php");
			?>
		</div>
		<div id="faq"><a href="../faq/"><img src="../../img/aide.png"></a></div>

		<div id="menu">

			<div id="menu1">
				<a href="../"><img src="../../img/menu/accueil.png"></a>
				<a href="../fournitures/"><img src="../../img/menu/article.png"></a>
				<?php 
				if(!isset($_SESSION['id_parent']))
				{
					?>
					<a href="../inscription/"><img src="../../img/menu/inscription.png"></a>
					<?php
				}
				else
				{
					?>
					<a href="../compte/"><img src="../../img/menu/compte.png"></a>
					<?php 
				}
				?>
				<a href="../contact/"><img src="../../img/menu/contact.png"></a>
			</div>

		</div>

		<div id="notification">
			<a href="../notification/"><img src="../../img/menu/messagerie.png"></a>
		</div>

		<div id="panier">
			<a href="../panier/"><img src="../../img/menu/panier.png"></a>
		</div>

		<?php 
				if(isset($_SESSION['droits']))
				{
					if ($_SESSION['droits'] ==1 )
					{
					?>
					<div id="admin">
						<a href="../admin/"><img src="../../img/menu/admin.png"></a>
					</div>
					<?php
					}
				}

		?>

	</div>

	<div class="corps">

		<div id="workflow">
		</div>
		
		<!-- <div id="categories"> -->
			<?php
				/*$imgs = array("ecriture.png", "trousse.png", "etui.png", "cahiers.png", "protege.png", "classeur.png", "ardoise.png", "arts.png", "canson.png", "calculatrice.png");
				$i = 0;
				$db = new DB_connection();
				$requete = "SELECT DISTINCT(categorie) FROM Sous_categorie order by id_scat";
				$db->DB_query($requete);
				echo "<ul>";
				while($rub = $db->DB_object())
				{
					//echo "<li><a href=\"index.php?cat=".urlencode($rub->categorie)."\">".$rub->categorie."</a></li>";
					$str = trim($rub->categorie);
					echo "<li><a href=\"index.php?cat=".urlencode($rub->categorie)."\"><img src=\"../../img/rubrique/".$imgs[$i]."\" title=\"$str\"></a></li>";
					$i++;
				}
				echo "</ul>";
				$db->DB_done();*/
			?>
		<!-- </div> -->

		<div id="page">

			<div id="sse50">
				<div id="sses50">
					<ul>
						<?php
						$i = 0;
						$titres = array("Ecriture", "Trousse", "Crayons - Feutres", "Cahiers", "Protège-cahiers", "Classeurs", "Petit matériel", "Arts plastiques", "Papier dessin", "Dictionnaires - Calculatrices");
						$db = new DB_connection();
						$requete = "SELECT DISTINCT(categorie) FROM Sous_categorie order by id_scat";
						$db->DB_query($requete);
						while($rub = $db->DB_object())
						{
							$str = trim($rub->categorie);
							echo "<li><a title=\"$str\" href=\"?cat=".urlencode($rub->categorie)."\">".$titres[$i++]."</a></li>";
						}
						$db->DB_done();
						?>
					</ul>
				</div>
			</div><br>

			<form method="get" action="index.php">
				<table>
					<tr>
						<td>Rechercher un produit : </td>
						<td><input type="text" size="12" name="find"/></td>
						<td><input type="submit" class="btn" value="Rechercher"/></td>
					</tr>
				</table>
			</form>
		<?php
			function stripAccents($string)
			{
				return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
				'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
			}
			if(!empty($_GET["find"]))
			{
				$str = "Résultats de la recherche \"".htmlentities($_GET["find"], ENT_QUOTES)."\" : ";
				echo "<p class=\"tprod\">$str</p>";

				afficherFournitures($panier, "", "", $db->quote(stripAccents($_GET["find"])));
			}
			else if(!empty($_GET["cat"]))
			{
				echo "<p class=\"tprod\">".htmlentities($_GET["cat"], ENT_QUOTES)." :</p>";
				if(!empty($_GET["scat"]))
				{
					afficherFournitures($panier, $db->quote($_GET["cat"]), $db->quote($_GET["scat"]));
				}
				else
				{
					afficherFournitures($panier, $db->quote($_GET["cat"]));
				}
			}
			else
			{
				echo "<p class=\"tprod\">Tous les produits :</p>";
				afficherFournitures($panier);
			}
		?>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>