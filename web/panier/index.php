<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_liste_affichage.php');

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
						if(isset($_SESSION['panier']))
						{
							$ids = array_keys($_SESSION['panier']);
							//var_dump($_SESSION['panier'][38404]);
							//unset($_SESSION['panier'][2]);
							//var_dump($ids);
							if(empty($ids))
							{
								$products = array();
							}
							else
							{
								$db = new DB_connection();
								$query = 'SELECT * FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
								$db->DB_query($query);

								if($db->DB_count() > 0)
								{
									echo "<table>
									<tr>
										<th>Référence</th>
										<th>Description</th>
										<th>Prix</th>
										<th>Quantité</th>
										<th></th>
									</tr>";
									while($mat = $db->DB_object())
									{
										//echo $_SESSION['panier'][$mat->id_mat];
										echo "<td>".$mat->ref_mat."</td>
										<td>".$mat->desc_mat."</td>
										<td>".$mat->prix_mat." €</td>
										<td><input type=\"number\" name=\"qte\" value=".$_SESSION['panier'][$mat->id_mat]." size=\"1\" min=\"1\" max=\"20\"></td>";
										echo "</tr>";
									}
									echo "</table>";
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