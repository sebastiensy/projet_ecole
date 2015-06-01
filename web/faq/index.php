<?php

session_start();
require_once('../../inc/data.inc.php');

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

		<div id="page">

		<p class="titre">Foire aux questions</p>

		<ul>
		<li><a href="#aun">Comment ajouter une/des liste(s) au panier ?</a></li>
		<li><a href="#adeux">Comment ajouter une/des fourniture(s) au panier ?</a></li>
		<li><a href="#atrois">Comment supprimer un article du panier ?</a></li>
		<li><a href="#aquatre">Comment modifier la quantité d'un article du panier ?</a></li>
		<li><a href="#acinq">Comment sauvegarder le panier ?</a></li>
		<li><a href="#asix">Comment passer une commande ?</a></li>
		<li><a href="#asept">Comment consulter l'état de mes commandes ?</a></li>
		<li><a href="#ahuit">Comment obtenir le récapitulatif d'une commande ?</a></li>
		</ul>
		<hr>

		<p id="aun"><u>Comment ajouter une/des liste(s) au panier ?</u></p>
		Cliquez sur l'onglet accueil

		<p id="adeux"><u>Comment ajouter une/des fourniture(s) au panier ?</u></p>
		

		<p id="atrois"><u>Comment supprimer un article du panier ?</u></p>
		

		<p id="aquatre"><u>Comment modifier la quantité d'un article du panier ?</u></p>
		

		<p id="acinq"><u>Comment sauvegarder le panier ?</u></p>
		

		<p id="asix"><u>Comment passer une commande ?</u></p>
		

		<p id="asept"><u>Comment consulter l'état de mes commandes ?</u></p>
		

		<p id="ahuit"><u>Comment obtenir le récapitulatif d'une commande ?</u></p>
		


			</div>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');

?>