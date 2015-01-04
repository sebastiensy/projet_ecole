<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_connexion.php');
require_once(LIB.'/lib_hasher_mdp.php');

?>

	<body>

	<?php

	if(!isset($_POST['connexion']))
	{
		connexion();
	}
	else
	{
		/*
		verifier si l un des champs est vemaile 
		*/
		$bool=true;

		if(empty($_POST['email'])){$bool=false;}
		if(empty($_POST['pass'])){$bool=false;}

		if($bool)
		{
			/*
			Purification des variables
			*/
			$_POST["email"]=htmlEntities($_POST["email"]);
			$_POST["pass"]=htmlEntities($_POST["pass"]);

			/*
			perparation de la requete 
			*/
			$requete = 'select id_parent, mdp_parent, droits_parents from Parent where email_parent = "'.$_POST["email"].'"';

			/*
			connexion a la base via la classe DB_connection
			*/
			$db = new DB_connection();

			/*
			exécution de la requete 
			*/
			$db->DB_query($requete);

			/*
			exécution de la requete 
			*/	 
			$ligne = $db->DB_object();

			/*
			on vérifie que le résultat de la requête n'est pas null
			*/
			if($ligne != null)
			{
				/*
				on vérifie si le mot de passe du parent correspond
				*/
				$email = $_POST["email"];
				$mdp = $ligne->mdp_parent;
				$droits = $ligne->droits_parents;
				$id_parent = $ligne->id_parent;

				if($mdp == hasher_mdp($_POST["pass"]))
				{
					session_start();
					$_SESSION['id_parent'] = $id_parent;
					$_SESSION['email'] = $email;
					$_SESSION['password'] = $mdp;
					header('location: ../accueil/index.php?redirected=true');

					/*
					le mot de passe est correct
					selon le droit du parent on le redirige vers 
					l'interface qui lui correspond.
					*/
					if($droits == 0)
					{
						/*
						c est un parent sans droit d administration
						on le redirige vers la page precedente
						*/
						//header("location: index.php");
					}
					else
					{
						/*
						c'est un parent avec droit d administration
						on le redirige vers l'interface administrateur    
						*/
						//header("location: index.php");
					}
				}
				else
				{
					/*
					erreur de mot de passe
					*/
					//connexion();
					//echo "Identifiants incorrects.";
					header('location: ../accueil/index.php?redirected=false');
				}
			}
			else
			{
				/*
				quand le resultat de la requete est null on réaffiche 
				le formulaire avec son état précédent
				avec un message d'erreur
				*/
				//connexion();
				//echo "Identifiants incorrects.";
				header('location: ../accueil/index.php?redirected=false');
			}
			$db->DB_done();
		}
		else
		{
			/*
			si l'un des champs est vemaile
			on affiche un message 
			et le formulaire avec son état precedent
			*/
			//connexion();
			//echo "Veuillez renseigner tous les champs.";
			header('location: ../accueil/index.php?redirected=false');
		}
	}

	if(isset($_GET["redirected"]))
	{
		if($_GET["redirected"] == "false")
		{
			echo "<span style=\"color:red\">Identifiants incorrects.</span>";
		}
	}

	?>

