<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_listes.php');

?>

<body id="back">

	<div id="banner">
	</div>

	<div class="menu">

		<div id="connexion">
			<?php
				require_once("../connexion/login.php");
			?>
		</div> 

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

		<div id="panier">
			<a href="../panier/"><img src="../../img/menu/panier.png"></a>
		</div>

	</div>

	<div class="corps">

		<div id="page">

			<div id="pagepanier">
				<p class="titre">Panier</p>
				<?php
					if(!isset($_SESSION["id_parent"]))
					{
						echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour consulter votre panier.</strong></p></span>";
					}
					else
					{
						$panierL = 0;
						$panierF = 0;
						if(isset($_SESSION['liste']))
						{
							if(isset($_GET["delList"]))
							{
								$panier->delList($_GET['delList']);
							}
							if(isset($_POST["liste"]["qte"]) && isset($_POST["listes"]))
							{
								$panier->recalcList();
							}
							$ids = array_keys($_SESSION['liste']);
							if(!empty($ids))
							{
								echo "<div align=\"right\"><b>Listes</b></div><hr/>";
								$db = new DB_connection();
								$query = 'SELECT ln.id_nivliste, ln.forfait, n.Libelle from Niveau n, Liste_niveau ln WHERE ln.niveau = n.code AND id_nivliste IN ('.implode(',',$ids).') ORDER BY ln.niveau';
								$db->DB_query($query);

								if($db->DB_count() > 0)
								{
									$panierL = $panier->totalList();
									echo "<div id=\"panierL\">";
										echo "<form method=\"post\" action=\"\">";
										echo "<table>
										<tr>
											<th>Niveau</th>
											<th>Forfait</th>
											<th>Quantité</th>
											<th>Action</th>
										</tr>";
										while($liste = $db->DB_object())
										{
											
											echo "<tr><td><a class=\"fancy2\" href=\"../accueil/liste.php?id=".$liste->id_nivliste."\">".$liste->Libelle."</a></td>
											<td>".number_format($liste->forfait, 2, ',', ' ')." €</td>
											<td><input type=\"number\" name=\"liste[qte][".$liste->id_nivliste."]\" value=".$_SESSION['liste'][$liste->id_nivliste]." size=\"1\" min=\"1\" max=\"20\"></td>";
											echo "<td><a href=\"index.php?delList=".$liste->id_nivliste."\">Supprimer</td>";
											echo "</tr>";
										}
										echo "<tr><td colspan=\"4\" align=\"right\"><b>Prix total : ".number_format($panierL, 2, ',', ' ')." €</b></td></tr>
										</table>";
										echo "<input type=\"submit\" name=\"listes\" value=\"Recalculer\">";
										echo "<form>";
									echo "</div>";
								}
								echo "<br/><br/>";
							}
						}
						
						if(isset($_SESSION['panier']))
						{
							if(isset($_GET["del"]))
							{
								$panier->del($_GET['del']);
							}
							if(isset($_POST["panier"]["qte"]) && isset($_POST["fournitures"]))
							{
								$panier->recalc();
							}
							$ids = array_keys($_SESSION['panier']);
							if(!empty($ids))
							{
								echo "<div align=\"right\"><b>Fournitures</b></div><hr/>";
								$db = new DB_connection();
								$query = 'SELECT * FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
								$db->DB_query($query);

								if($db->DB_count() > 0)
								{
									$panierF = $panier->total();
									echo "<div id=\"panierF\">";
										echo "<form method=\"post\" action=\"\">";
										echo "<table>
										<tr>
											<th>Référence</th>
											<th>Description</th>
											<th>Prix</th>
											<th>Quantité</th>
											<th>Action</th>
										</tr>";
										while($mat = $db->DB_object())
										{
											echo "<tr><td>".$mat->ref_mat."</td>
											<td>".$mat->desc_mat."</td>
											<td>".number_format($mat->prix_mat, 2, ',', ' ')." €</td>
											<td><input type=\"number\" name=\"panier[qte][".$mat->id_mat."]\" value=".$_SESSION['panier'][$mat->id_mat]." size=\"1\" min=\"1\" max=\"20\"></td>";
											echo "<td><a href=\"index.php?del=".$mat->id_mat."\">Supprimer</td>";
											echo "</tr>";
										}
										echo "<tr><td colspan=\"5\" align=\"right\"><b>Prix total : ".number_format($panierF, 2, ',', ' ')." €</b></td></tr>
										</table>";
										echo "<input type=\"submit\" name=\"fournitures\" value=\"Recalculer\">";
										echo "<form>";
									echo "</div>";
								}
							}
						}
						$grandtotal = $panierL + $panierF;
						echo "<hr/><div align=\"center\"><b><u>Prix total du panier</u> : ".number_format($grandtotal, 2, ',', ' ')." €</b></div>";
					}
				?>
			</div>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');

?>