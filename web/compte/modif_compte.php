<?php

require_once('../../inc/data.inc.php');

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
	
	<div id="page">

	

<?php

// Pour test
//$id_parent = 3;

session_start();

$db = new DB_connection();


echo 'Mon compte';

	if(isset($_GET['compte']))
	{
		$compte = $_GET['compte'];

		if ($compte == 'nom')
		{
			?>
			<form method="post" action="modif_compte.php">
			<p> <label class="modif_compte" for="nom">Nom :</label> <input type="text" name="nom_parent"/></p>
			<input type="submit" value="Enregistrer">
			</form>

			<?php

		}
		elseif ($compte == 'email') {
			?>
			<form method="post" action="modif_compte.php">
			<p> <label class="modif_compte" for="email">Nouvelle adresse email :</label> <input type="text" name="email_parent"/></p>
			<input type="submit" value="Enregistrer">
			</form>

			<?php
		}
		elseif ($compte == 'tel') {
			?>
			<form method="post" action="modif_compte.php">
			<p> <label class="modif_compte" for="tel">Numero de telephone :</label> <input type="text" name="tel"/></p>
			<input type="submit" value="Enregistrer">
			</form>

			<?php
		}
		elseif ($compte == 'mdp') {
			?>
			<form method="post" action="modif_compte.php">
			<p> <label class="modif_compte" for="mdp">Mot de passe actuel :</label> <input type="password" name="anc_mdp"/></p>
			<p> <label class="modif_compte" for="mdp">Nouveau mot de passe :</label> <input type="password" name="mdp1"/></p>
			<p> <label class="modif_compte" for="mdp">Saisissez une seconde fois le nouveau mot de passe :</label> <input type="password" name="mdp2"/></p>
			<input type="submit" value="Enregistrer">
			</form>

			<?php
		}
		elseif ($compte == 'enfant') {
			?>
			<form method="post" action="modif_compte.php">
			<p> <label class="modif_compte" for="enfant">Nombre d'enfants :</label> <input type="text" name="enfant"/></p>
			<input type="submit" value="Enregistrer">
			</form>

			<?php
		}
	}
	
	if (isset($_POST['nom_parent']))
	{
		$modifier = 'UPDATE Parent SET nom_parent = "'.$_POST['nom_parent'].'" WHERE id_parent = '.$_SESSION['id_parent'];
		$db->DB_query($modifier);
		header('Location: index.php');
		
	}
	if (isset($_POST['email_parent']))
	{
		$modifier = 'UPDATE Parent SET email_parent = "'.$_POST['email_parent'].'" WHERE id_parent = '.$_SESSION['id_parent'];
		$db->DB_query($modifier);
		header('Location: index.php');
		
	}
	if (isset($_POST['tel']))
	{
		$modifier = 'UPDATE Parent SET tel_parent = "'.$_POST['tel'].'" WHERE id_parent = '.$_SESSION['id_parent'];
		$db->DB_query($modifier);
		header('Location: index.php');
		
	}
	if (isset($_POST['anc_mdp']) && isset($_POST['mdp1']) && isset($_POST['mdp2']))
	{
		$verif_mdp = 'SELECT p.id_parent, p.mdp_parent FROM Parent as p WHERE p.id_parent = '.$_SESSION['id_parent'];
		$db->DB_query($verif_mdp);
		while ($mdp = $db->DB_object()) {
			if ($_POST['mdp1'] == $_POST['mdp2'] && $_POST['anc_mdp'] == $mdp->mdp_parent)
			{
				$modifier = 'UPDATE Parent SET mdp_parent = "'.$_POST['mdp2'].'" WHERE id_parent = '.$_SESSION['id_parent'];
				$db->DB_query($modifier);
				header('Location: index.php');
				
			}
			else {
				print('<script type="text/javascript">location.href="modif_compte.php?compte=mdp";</script>');

			}
		}
	}
	if (isset($_POST['enfant']))
	{
		$modifier = 'UPDATE Parent SET nb_enfants = "'.$_POST['enfant'].'" WHERE id_parent = '.$_SESSION['id_parent'];
		$db->DB_query($modifier);
		header('Location: index.php');
		
	}


$db->DB_done();	

echo "</div>";


?>

<?php

require_once(INC.'/footer.inc.php');

?>