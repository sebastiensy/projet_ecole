<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_modifier.php');
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

	<div id="page">

<?php

if(!isset($_SESSION["id_parent"]))
{
	header("Location: ../index.php");
}

$db = new DB_connection();

echo "<a href=\"index.php\"/>Retour</a>";

echo '<p><b><u>Mon compte</u></b></p>';

	if(isset($_GET['compte']))
	{
		$compte = $_GET['compte'];

		if ($compte == 'nom')
		{
			afficForm("", "nom", $_SESSION["nom_parent"]);
		}
		elseif ($compte == 'email')
		{
			afficForm("", "email", $_SESSION["email"]);
		}
		elseif ($compte == 'tel')
		{
			afficForm("", "tel", $_SESSION["tel_parent"]);
		}
		elseif ($compte == 'mdp') {
			afficForm("", "mdp");
		}
		elseif ($compte == 'enfant') {
			afficForm("", "enfant", $_SESSION["nb_enfants"]);
		}
	}

	if (isset($_POST['nom_parent']))
	{
		if(verifLogin($_POST["nom_parent"]) && !empty($_POST["nom_parent"]))
		{
			$modifier = 'UPDATE Parent SET nom_parent = "'.$_POST['nom_parent'].'" WHERE id_parent = '.$_SESSION['id_parent'];
			$db->DB_query($modifier);
			$_SESSION["nom_parent"] = $_POST["nom_parent"];
			header('Location: index.php');
		}
		else
			afficForm("Le nom doit comporter entre 1 et 40 caractères.", "nom", $_POST["nom_parent"]);
	}
	if (isset($_POST['email_parent']))
	{
		if(verifEmail($_POST["email_parent"]))
		{
			if(emailLibre($_POST["email_parent"], $db))
			{
				$modifier = 'UPDATE Parent SET email_parent = "'.$_POST['email_parent'].'" WHERE id_parent = '.$_SESSION['id_parent'];
				$db->DB_query($modifier);
				$_SESSION["email"] = $_POST["email_parent"];
				header('Location: index.php');
			}
			else
				afficForm("Cet email existe déjà.", "email", $_POST["email_parent"]);
		}
		else
			afficForm("Email invalide.", "email", $_POST["email_parent"]);
	}
	if (isset($_POST['tel']))
	{
		if(verifTel($_POST["tel"]))
		{
			$modifier = 'UPDATE Parent SET tel_parent = "'.$_POST['tel'].'" WHERE id_parent = '.$_SESSION['id_parent'];
			$db->DB_query($modifier);
			$_SESSION["tel_parent"] = $_POST["tel"];
			header('Location: index.php');
		}
		else
			afficForm("Téléphone invalide.", "tel", $_POST["tel"]);
	}
	if (isset($_POST['anc_mdp']) && isset($_POST['mdp1']) && isset($_POST['mdp2']))
	{
		$verif_mdp = 'SELECT p.mdp_parent FROM Parent as p WHERE p.id_parent = '.$_SESSION['id_parent'];
		$db->DB_query($verif_mdp);
		if ($mdp = $db->DB_object())
		{
			if(hasher_mdp($_POST['anc_mdp']) == $mdp->mdp_parent)
			{
				if(verifMdp($_POST['mdp1']))
				{
					if ($_POST['mdp1'] == $_POST['mdp2'])
					{
						$modifier = 'UPDATE Parent SET mdp_parent = "'.hasher_mdp($_POST['mdp2']).'" WHERE id_parent = '.$_SESSION['id_parent'];
						$db->DB_query($modifier);
						//$_SESSION["password"] = $_POST["mdp1"];
						header('Location: index.php');
					}
					else
						afficForm("Les mots de passe ne correspondent pas.", "mdp");
				}
				else
					afficForm("Le mot de passe doit comporter entre 6 et 16 caractères.", "mdp");
			}
			else
				afficForm("Ancien mot de passe incorrect.", "mdp");
		}
	}
	if (isset($_POST['enfant']))
	{
		if(verifEnfant($_POST["enfant"]))
		{
			$modifier = 'UPDATE Parent SET nb_enfants = "'.$_POST['enfant'].'" WHERE id_parent = '.$_SESSION['id_parent'];
			$db->DB_query($modifier);
			$_SESSION["nb_enfants"] = $_POST["enfant"];
			header('Location: index.php');
		}
		else
			afficForm("Veuillez renseigner le champ.", "enfant", $_POST['enfant']);
	}

$db->DB_done();	

echo "</div></div>";

?>

<?php

require_once(INC.'/footer.inc.php');

?>