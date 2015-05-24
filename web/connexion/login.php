<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_connexion.php');
require_once(LIB.'/lib_hasher_mdp.php');

?>

	<?php

	if(!isset($_POST['connexion']))
	{
		connexion();
	}
	else
	{
		$bool=true;

		if(empty($_POST['email'])){$bool=false;}
		if(empty($_POST['pass'])){$bool=false;}

		if($bool)
		{
			// purification des variables
			$_POST["email"]=htmlEntities($_POST["email"]);
			$_POST["pass"]=htmlEntities($_POST["pass"]);

			$requete = 'select * from Parent where email_parent = "'.$_POST["email"].'" AND id_etat > 1';

			// connexion a la base via la classe DB_connection
			$db = new DB_connection();

			$db->DB_query($requete);

			$ligne = $db->DB_object();

			// vérifie que le résultat de la requête n'est pas nul
			if($ligne != null)
			{
				// vérifie si le mot de passe du parent correspond
				$mdp = $ligne->mdp_parent;

				if($mdp == hasher_mdp($_POST["pass"]))
				{
					$id_parent = $ligne->id_parent;
					$nom_parent = $ligne->nom_parent;
					$email = $ligne->email_parent;
					$tel_parent = $ligne->tel_parent;
					$nb_enfants = $ligne->nb_enfants;
					$droits = $ligne->droits_parents;

					session_start();
					$_SESSION['id_parent'] = $id_parent;
					$_SESSION['nom_parent'] = $nom_parent;
					$_SESSION['tel_parent'] = $tel_parent;
					$_SESSION['nb_enfants'] = $nb_enfants;
					$_SESSION['droits'] = $droits;
					$_SESSION['email'] = $email;
					//$_SESSION['password'] = $mdp;

					$panier->loadCart();

					//create_fonction(); // ?
					
					header('location: ../accueil/index.php?redirected=true');

					/*
					le mot de passe est correct
					selon le droit du parent on le redirige vers 
					l'interface qui lui correspond.
					*/
					if($droits == 0)
					{
						/*
						c'est un parent sans droit d'administration
						on le redirige vers la page précédente
						*/
						//header("location: index.php");
					}
					else
					{
						/*
						c'est un parent avec droit d'administration
						on le redirige vers l'interface administrateur    
						*/
						//header("location: index.php");
					}
				}
				else
				{
					// erreur de mot de passe
					header('location: ../accueil/index.php?redirected=false');
				}
			}
			else
			{
				/*
				quand le resultat de la requete est null on rÃ©affiche 
				le formulaire avec son Ã©tat prÃ©cÃ©dent
				avec un message d'erreur
				*/
				header('location: ../accueil/index.php?redirected=false');
			}
			$db->DB_done();
		}
		else
		{
			/*
			si l'un des champs est vemaile
			on affiche un message 
			et le formulaire avec son Ã©tat precedent
			*/
			header('location: ../accueil/index.php?redirected=false');
		}
	}

	if(isset($_GET["redirected"]))
	{
		if($_GET["redirected"] == "false" && empty($_SESSION['id_parent']))
		{
			echo "<span id=\"msgErr\" style=\"color:red\">Identifiants incorrects.</span>";
		}
	}

	?>