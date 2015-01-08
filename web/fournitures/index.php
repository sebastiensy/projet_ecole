<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_fournitures.php');
require_once(LIB.'/lib_creation_panier.php');

?>

<body id="back">

	<div id="banner">
	</div>

	<div class="menu">
	
		<div id="menu">

			<div id="menu1">
				<a href="../"><img src="../../img/menu/acceuil.png"></a>
				<a href="../fournitures/"><img src="../../img/menu/article.png"></a>
				<a href="../inscription/"><img src="../../img/menu/inscription.png"></a>
				<a href="../contact/"><img src="../../img/menu/contact.png"></a>
			</div>

		</div>

		<div id="panier">
			<a href="../panier/"><img src="../../img/menu/panier.png"></a>
		</div>

		<div id="connexion">
			<?php
			require_once("../connexion/login.php");
			?>
		</div>

	</div>

	<div class="corps">

		<div id="categories">
			<?php
				$imgs = array("ecriture.png", "trousse.png", "etui.png", "cahiers.png", "protege.png", "classeur.png", "ardoise.png", "arts.png", "canson.png", "calculatrice.png");
				$i = 0;
				$db = new DB_connection();
				$requete = "SELECT DISTINCT(categorie) FROM sous_categorie order by id_scat";
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
				$db->DB_done();
			?>
		</div>

		<div id="page">
			<form method="get" action="index.php">
				<table>
					<tr>
						<td>Rechercher un produit : </td>
						<td><input type="text" size="12" name="find"/></td>
						<td><input type="submit" value="Rechercher"/></td>
					</tr>
				</table>
			</form>
		<?php
			function stripAccents($string)
			{
				return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
				'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
			}
			if(!empty($_GET["find"]))
			{
				$str = "R&eacute;sultats de la recherche \"".$_GET["find"]."\" : ";
				echo "<p class=\"tprod\">$str</p>";

				afficherFournitures("", "", stripAccents($_GET["find"]));
			}
			else if(!empty($_GET["cat"]))
			{
				echo "<p class=\"tprod\">".$_GET["cat"]." :</p>";
				if(!empty($_GET["scat"]))
				{
					afficherFournitures(htmlSpecialChars($_GET["cat"]), htmlSpecialChars($_GET["scat"]));
				}
				else
				{
					afficherFournitures(htmlSpecialChars($_GET["cat"]));
				}
			}
			else
			{
				echo "<p class=\"tprod\">Tous les produits :</p>";
				afficherFournitures();
			}
		?>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>