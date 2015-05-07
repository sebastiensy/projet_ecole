<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_listes.php');

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
						if(isset($_SESSION['liste']))
						{
							echo "<div align=\"right\"><b>Listes</b></div><hr/>";
							if(isset($_GET["delList"]))
							{
								$panier->delList($_GET['delList']);
							}
							if(isset($_POST["liste"]["qte"]))
							{
								$panier->recalcList();
							}
							$ids = array_keys($_SESSION['liste']);
							if(!empty($ids))
							{
								$db = new DB_connection();
								$query = 'SELECT ln.id_nivliste, ln.forfait, n.Libelle from Niveau n, Liste_niveau ln WHERE ln.niveau = n.code AND id_nivliste IN ('.implode(',',$ids).')';
								$db->DB_query($query);

								if($db->DB_count() > 0)
								{
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
										echo "<tr><td>".$liste->Libelle."</td>
										<td>".$liste->forfait." €</td>
										<td><input type=\"number\" name=\"liste[qte][".$liste->id_nivliste."]\" value=".$_SESSION['liste'][$liste->id_nivliste]." size=\"1\" min=\"1\" max=\"20\"></td>";
										echo "<td><a href=\"index.php?delList=".$liste->id_nivliste."\">Supprimer</td>";
										echo "</tr>";
									}
									echo "<tr><td colspan=\"4\" align=\"right\"><b>Prix total : ".$panier->totalList()." €</b></td></tr>
									</table>";
									echo "<input type=\"submit\" value=\"Recalculer\">";
									echo "<form>";
								}
							}
						}
						echo "<br/><br/><br/><br/>";
						
						if(isset($_SESSION['panier']))
						{
							echo "<div align=\"right\"><b>Fournitures</b></div><hr/>";
							if(isset($_GET["del"]))
							{
								$panier->del($_GET['del']);
							}
							if(isset($_POST["panier"]["qte"]))
							{
								$panier->recalc();
							}
							$ids = array_keys($_SESSION['panier']);
							if(!empty($ids))
							{
								$db = new DB_connection();
								$query = 'SELECT * FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
								$db->DB_query($query);

								if($db->DB_count() > 0)
								{
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
										<td>".$mat->prix_mat." €</td>
										<td><input type=\"number\" name=\"panier[qte][".$mat->id_mat."]\" value=".$_SESSION['panier'][$mat->id_mat]." size=\"1\" min=\"1\" max=\"20\"></td>";
										echo "<td><a href=\"index.php?del=".$mat->id_mat."\">Supprimer</td>";
										echo "</tr>";
									}
									echo "<tr><td colspan=\"5\" align=\"right\"><b>Prix total : ".$panier->total()." €</b></td></tr>
									</table>";
									echo "<input type=\"submit\" value=\"Recalculer\">";
									echo "<form>";
								}
							}
						}
					}
				?>
			</div>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');

?>