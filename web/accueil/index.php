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
			<?php affichage(); ?>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');

?>