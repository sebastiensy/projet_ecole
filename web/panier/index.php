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
							var_dump($ids);
							if(empty($ids))
							{
								$products = array();
							}
							else
							{
								$db = new DB_connection();
								$products = $db->DB_query('SELECT ref_mat, prix_mat FROM Materiel WHERE ref_mat IN ('.implode(',',$ids).')');
							}
							foreach($products as $product)
							{
								
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