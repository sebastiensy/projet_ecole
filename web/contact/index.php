<?php

session_start();
require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_contacter.php');
require_once(LIB.'/lib_verifications.php');
require_once(LIB.'/lib_message.php');
require_once(INC.'/redirect.inc.php');

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
			if($_SESSION['droits'] == 1)
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

	<p class="titre">Contact</p>
	<?php

		if(!isset($_POST["ok"]))
		{
			if(isset($_SESSION["email"]))
				formulaire_contacter($_SESSION["email"], "objet", "message");
			else
				formulaire_contacter("email", "objet", "message");
		}
		else
		{
			// verifie si l'un des champs est vide
			$bool=true;
			if(empty($_POST["email"])){ $bool=false;}
			if(empty($_POST["objet"])){ $bool=false;}
			if(empty($_POST["message"])){ $bool=false;}

			$email = htmlentities($_POST["email"], ENT_QUOTES);
			$objet = htmlentities($_POST["objet"], ENT_QUOTES);
			$message = htmlentities($_POST["message"], ENT_QUOTES);
			if(!$bool)
			{
				/*
				si l'un des champs est vide 
				on affiche un message 
				et le formulaire avec sont état précédent
				*/
				echo "<p><span style=\"color:red\">Vous devez remplir tous les champs.</span></p>";
				formulaire_contacter($email, $objet, $message);
			}
			else if(!verifEmail($_POST["email"]))
			{
				echo "<p><span style=\"color:red\">Email invalide.</span></p>";
				formulaire_contacter($email, $objet, $message);
			}
			else if(rpHash($_POST['captcha']) != $_POST['captchaHash'])
			{
				echo "<p><span style=\"color:red\">Le captcha est incorrect.</span></p>";
				formulaire_contacter($email, $objet, $message);
			}
			else
			{
				// les champs sont remplis, écriture dans la base

				// connexion a la base via la classe DB_connection
				$db = new DB_connection();

				$requete='SELECT id_parent FROM Parent WHERE droits_parents = 1';
				$db->DB_query($requete);
				if($db->DB_count() > 0)
				{
						if($admin = $db->DB_object())
						{
							message($db->quote($_POST["email"]), $db->quote($_POST["objet"]), $db->quote($_POST["message"]), 1, $admin->id_parent);
						}
				}
				$db->DB_done();

				// réaffichage du formulaire vide 
				echo "<strong><p><span style=\"color:green\">Votre message a bien été transmis.</span></p></strong><br/>";
				formulaire_contacter("", "", "");
			}
		}

	?>

	</div>
	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>