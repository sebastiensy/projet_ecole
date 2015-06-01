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
		</ul>
		<hr>

		<p id="aun"><u>Comment ajouter une/des liste(s) au panier ?</u></p>
		Rendez-vous sur la page nommée <a id="fa" href="../accueil">Accueil</a>, renseignez la quantité pour la liste souhaitée 
		puis cliquez sur l'icône d'ajout au panier.

		<p id="adeux"><u>Comment ajouter une/des fourniture(s) au panier ?</u></p>
		Rendez-vous sur la page nommée <a id="fa" href="../fournitures">Articles</a>, renseignez la quantité pour la fourniture 
		souhaitée puis cliquez sur l'icône d'ajout au panier.

		<p id="atrois"><u>Comment supprimer un article du panier ?</u></p>
		Rendez-vous sur la page du <a id="fa" href="../panier">panier</a>, cliquez sur l'icône représentant une corbeille 
		au niveau du tableau des listes ou celui des fouritures.

		<p id="aquatre"><u>Comment modifier la quantité d'un article du panier ?</u></p>
		Rendez-vous sur la page du <a id="fa" href="../panier">panier</a>, renseignez la nouvelle quantité pour la liste ou 
		la fourniture considérée, puis cliquez sur le bouton "Recalculer" associé.

		<p id="acinq"><u>Comment sauvegarder le panier ?</u></p>
		Rendez-vous sur la page du <a id="fa" href="../panier">panier</a>, celui-ci doit contenir au moins une liste ou 
		une fourniture, puis cliquez sur le bouton "Sauvegarder le panier". A votre prochaine 
		connexion, le contenu du panier sera automatiquement restitué si la commande 
		n'a pas encore été passée.

		<p id="asix"><u>Comment passer une commande ?</u></p>
		Rendez-vous sur la page du <a id="fa" href="../panier">panier</a>, celui-ci doit contenir au moins une liste ou 
		une fourniture, puis cliquez sur le bouton "Commander". Le contenu du panier sera 
		automatiquement vidé et vous pourrez entamer une nouvelle commande.

		<p id="asept"><u>Comment consulter l'état de mes commandes ?</u></p>
		Après vous être connecté, rendez-vous sur la page nommée <a id="fa" href="../compte">Compte</a>, puis cliquez 
		sur le bouton "Suivi de mes commandes". (Vous devez avoir au moins une commande 
		pour que celui-ci apparaisse.)

			</div>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');

?>