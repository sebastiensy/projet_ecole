<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_inscription.php');

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
	</div>
	<div class="corps">
	<div id="page">
	
	<?php

		if(!isset($_POST["sinscrire"]))
		{
			formulaire_inscription();
		}
		else
		{
			/*
			verifier si l'un des champs est vide 
			*/
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
				si l un des chaps est vide 
				on affiche un message 
				et le formulaire avec son etat precedent
				*/
				formulaire_inscription("Veuillez remplir tous les champs.", $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
			}
			else
			{
				/*
				connexion a la base via la classe DB_connection
				*/
				$db = new DB_connection();

				/*
				verifie si l'email n'existe pas déjà
				sinon reaffichage du formulaire avec son etat precedent
				et un message 
				*/
				$requete = 'Select id_parent from Parent where email_parent = "'.$_POST["email"].'"';
				$db->DB_query($requete);
				if($db->DB_count() > 0)
				{
					formulaire_inscription("Cet email existe déjà." ,$_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
				}
				else if($_POST["mdp"]!==$_POST["cmdp"])
				{
					/*
					verifier si les mots de passe correspondent
					sinon reaffichage du formulaire avec son etat precedent
					et un message 
					*/
					formulaire_inscription("Mot de passe incorrect." ,$_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["mdp"], "", $_POST["nbrenfant"]);
				}
				else
				{
					/*
					toute les conditions sont verfiées 
					on inseert dans la base 
					*/

					/*
					Purification des variable
					*/
					$_POST["nom"]=htmlEntities($_POST["nom"]);
					$_POST["email"]=htmlEntities($_POST["email"]);
					$_POST["tel"]=htmlEntities($_POST["tel"]);
					$_POST["tel"]=htmlEntities($_POST["mdp"]);
					$_POST["nbrenfant"]=htmlEntities($_POST["nbrenfant"]);

					/*
					preparation de la requete 
					*/
					$requete='insert into parent (nom_parent, mdp_parent, email_parent, tel_parent, nb_enfants, droits_parents) values("'.$_POST['nom'].'","'.$_POST['email'].'","'.$_POST['tel'].'","'.$_POST['mdp'].'",'.$_POST['nbrenfant'].', 0)';  

					/*
					execution de la requete 
					*/
					$db->DB_query($requete);
					$db->DB_done();
				}
			}
		}

	?>

	</div>
	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>