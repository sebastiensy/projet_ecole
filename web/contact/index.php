<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_contacter.php');

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

	<p class="titre">Contact</p>
	<?php

		if(!isset($_POST["ok"]))
		{
			formulaire_contacter("email", "objet", "message");
		}
		else
		{
			// verifie si l'un des champs est vide
			$bool=true;
			if(empty($_POST["email"])){ $bool=false;}
			if(empty($_POST["objet"])){ $bool=false;}
			if(empty($_POST["message"])){ $bool=false;}

			if(!$bool)
			{
				/*
				si l'un des champs est vide 
				on affiche un message 
				et le formulaire avec sont �tat pr�c�dent
				*/
				echo "<p><span style=\"color:red\">Vous devez remplir tous les champs.</span></p>";
				formulaire_contacter($_POST["email"],$_POST["objet"],$_POST["message"]);
			}
			else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
			{
				echo "<p><span style=\"color:red\">Email invalide.</span></p>";
				formulaire_contacter($_POST["email"],$_POST["objet"],$_POST["message"]);
			}
			else
			{
				// les champs sont remplis, ecriture dans la base

				// connexion a la base via la classe DB_connection
				$db = new DB_connection();

				// purification des variables
				$_POST["message"]=htmlSpecialChars($_POST["message"]);
				$_POST["objet"]=htmlSpecialChars($_POST["objet"]);
				$_POST["email"]=htmlSpecialChars($_POST["email"]);

				// requ�te
				$requete='insert into Message (email_parent, objet, message,jma, lu) values("'.$_POST["email"].'", "'.$_POST["objet"].'", "'.$_POST["message"].'",NOW(), 0)';

				// ex�cution de la requete
				$db->DB_query($requete);
				$db->DB_done();

				// r�affichage du formulaire vide 
				echo "<p>Votre message a bien �t� transmis.</p>";
				formulaire_contacter("", "", "");
			}
		}

	?>

	</div>
	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>