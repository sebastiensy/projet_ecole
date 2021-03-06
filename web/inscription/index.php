<?php

session_start();
require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_inscription.php');
require_once(LIB.'/lib_hasher_mdp.php');
require_once(LIB.'/lib_verifications.php');
require_once(INC.'/redirect.inc.php');

?>

<?php
if(isset($_SESSION["id_parent"]))
{
	header("Location: ../index.php");
	exit;
}
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

	<p class="titre">Inscription</p>
	<?php

		if(!isset($_POST["sinscrire"]))
		{
			formulaire_inscription();
		}
		else
		{
			// v�rifie si l'un des champs est vide 
			$bol=true;

			if(empty($_POST["nom"])){ $bol=false;}
			if(empty($_POST["email"])){ $bol=false;}
			if(empty($_POST["tel"])){ $bol=false;}
			if(empty($_POST["mdp"])){ $bol=false;}
			if(empty($_POST["cmdp"])){ $bol=false;}
			if(empty($_POST["nbrenfant"])){ $bol=false;}

			$nom = htmlentities(trim($_POST["nom"]), ENT_QUOTES);
			$email = htmlentities($_POST["email"], ENT_QUOTES);
			$tel = htmlentities($_POST["tel"], ENT_QUOTES);
			$mdp = htmlentities($_POST["mdp"], ENT_QUOTES);
			$nbrenfant = htmlentities($_POST["nbrenfant"], ENT_QUOTES);
			if(!$bol)
			{
				/*
				si l'un des champs est vide 
				on affiche un message 
				et le formulaire avec son �tat pr�c�dent
				*/
				formulaire_inscription("Veuillez remplir tous les champs.", $nom, $email, $tel, $mdp, "", $nbrenfant);
			}
			else if(!verifLogin($_POST["nom"]))
			{
				formulaire_inscription("Le nom ne doit pas d�passer 40 caract�res.", $nom, $email, $tel, $mdp, "", $nbrenfant);
			}
			else if(!verifEmail($_POST["email"]))
			{
				formulaire_inscription("Email invalide.", $nom, $email, $tel, $mdp, "", $nbrenfant);
			}
			else if(!verifTel($_POST["tel"]))
			{
				formulaire_inscription("T�l�phone invalide.", $nom, $email, $tel, $mdp, "", $nbrenfant);
			}
			else if(!verifMdp($_POST["mdp"]))
			{
				formulaire_inscription("Le mot de passe doit comporter entre 6 et 16 caract�res.", $nom, $email, $tel, $mdp, "", $nbrenfant);
			}
			else if(rpHash($_POST['captcha']) != $_POST['captchaHash'])
			{
				formulaire_inscription("Le captcha est incorrect.", $nom, $email, $tel, $mdp, "", $nbrenfant);
			}
			else
			{
				// connexion a la base via la classe DB_connection
				$db = new DB_connection();

				/*
				v�rifie si l'email n'existe pas d�j�
				sinon r�affichage du formulaire avec son �tat pr�c�dent
				et un message 
				*/
				if(!emailLibre($db->quote($_POST["email"]), $db))
				{
					formulaire_inscription("Cet email existe d�j�.", $nom, $email, $tel, $mdp, "", $nbrenfant);
				}
				else if($_POST["mdp"] != $_POST["cmdp"])
				{
					/*
					verifie si les mots de passe correspondent
					sinon r�affichage du formulaire avec son �tat pr�c�dent
					et un message 
					*/
					formulaire_inscription("Les mots de passe ne correspondent pas.", $nom, $email, $tel, $mdp, "", $nbrenfant);
				}
				else
				{
					// toutes les conditions sont v�rifi�es, insertion dans la base

					$requete = 'insert into Parent (nom_parent, email_parent, tel_parent, mdp_parent, nb_enfants, droits_parents, id_etat) values("'.$db->quote(trim($_POST['nom'])).'","'.$db->quote($_POST['email']).'","'.$db->quote($_POST['tel']).'","'.hasher_mdp($db->quote($_POST['mdp'])).'",'.$db->quote($_POST['nbrenfant']).', 0, 1)';  

					// ex�cution de la requ�te 
					$db->DB_query($requete);
					$db->DB_done();
					
					echo "<span style=\"color:green\"><p><strong>Inscription en attente de validation.</strong></p></span>";
				}
			}
		}

	?>

	</div>
	</div>

<?php

?>

<?php

require_once(INC.'/footer.inc.php');
	
?>