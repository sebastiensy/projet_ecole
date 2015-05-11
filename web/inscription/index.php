<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_inscription.php');
require_once(LIB.'/lib_hasher_mdp.php');
require_once(LIB.'/lib_verifications.php');

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

	<p class="titre">Inscription</p>
	<?php

		if(isset($_SESSION["id_parent"]))
		{
			header("Location: ../index.php");
		}

		if(!isset($_POST["sinscrire"]))
		{
			formulaire_inscription();
		}
		else
		{
			// vérifie si l'un des champs est vide 
			$bol=true;

			if(empty($_POST["nom"])){ $bol=false;}
			if(empty($_POST["email"])){ $bol=false;}
			if(empty($_POST["tel"])){ $bol=false;}
			if(empty($_POST["mdp"])){ $bol=false;}
			if(empty($_POST["cmdp"])){ $bol=false;}
			if(empty($_POST["nbrenfant"])){ $bol=false;}

			if(!$bol)
			{
				/*
				si l'un des champs est vide 
				on affiche un message 
				et le formulaire avec son état précédent
				*/
				formulaire_inscription("Veuillez remplir tous les champs.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
			}
			else if(!verifLogin($_POST["nom"]))
			{
				formulaire_inscription("Le nom ne doit pas dépasser 40 caractères.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
			}
			else if(!verifMdp($_POST["mdp"]))
			{
				formulaire_inscription("Le mot de passe doit comporter entre 6 et 16 caractères.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
			}
			else if(!verifEmail($_POST["email"]))
			{
				formulaire_inscription("Email invalide.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
			}
			else if(!verifTel($_POST["tel"]))
			{
				formulaire_inscription("Téléphone invalide.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
			}
			else
			{
				// connexion a la base via la classe DB_connection
				$db = new DB_connection();

				/*
				vérifie si l'email n'existe pas déjà
				sinon réaffichage du formulaire avec son état précédent
				et un message 
				*/
				if(!emailLibre($_POST["email"], $db))
				{
					formulaire_inscription("Cet email existe déjà." ,$_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
				}
				else if($_POST["mdp"]!==$_POST["cmdp"])
				{
					/*
					verifie si les mots de passe correspondent
					sinon réaffichage du formulaire avec son état précédent
					et un message 
					*/
					formulaire_inscription("Mot de passe incorrect.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
				}
				else
				{
					// toutes les conditions sont vérifiées, insertion dans la base 

					// purification des variables
					$_POST["nom"]=htmlEntities($_POST["nom"]);
					$_POST["email"]=htmlEntities($_POST["email"]);
					$_POST["tel"]=htmlEntities($_POST["tel"]);
					$_POST["mdp"]=htmlEntities($_POST["mdp"]);
					$_POST["nbrenfant"]=htmlEntities($_POST["nbrenfant"]);

					// requête 
					$requete = 'insert into Parent (nom_parent, email_parent, tel_parent, mdp_parent, nb_enfants, droits_parents) values("'.$_POST['nom'].'","'.$_POST['email'].'","'.$_POST['tel'].'","'.hasher_mdp($_POST['mdp']).'",'.$_POST['nbrenfant'].', 0)';  

					// exécution de la requête 
					$db->DB_query($requete);
					$db->DB_done();
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