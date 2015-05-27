<?php

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
		<?php
		if(!isset($_SESSION["id_parent"]))
		{
			header("Location: ../index.php");
			exit;
		}
		?>

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

<?php

?>

<p class="titre">Mon compte</p>

<?php


if (isset($_SESSION['id_parent']))
{
	$requete = 'SELECT e.id_etat, e.libelle_etat FROM Etat as e, Parent as p WHERE p.id_etat = e.id_etat AND p.id_parent = '.$_SESSION['id_parent'];
	$db = new DB_connection();
	$db->DB_query($requete);

	while($etat = $db->DB_object())
	{
		
		for ($i=1; $i<=4; $i++) 
		{	
			echo "<script type='text/javascript'>";
			echo "var i = ".$i.";";
			echo "if ($etat->id_etat == i && $etat->id_etat != 5)
			{
				$('.".$i."').removeClass().addClass('active');
			}
			else if ($etat->id_etat >= i+1)
			{
				$('.".$i."').removeClass().addClass('visited');
			}
			else if ($etat->id_etat < i+1)
			{
				$('.".$i."').removeClass().addClass('next');
			}
			else if ($etat->id_etat == 5)
			{
				$('.".$i."').removeClass().addClass('visited');
			}"; 
			echo "</script>";

		}
	}
}

$requete = 'SELECT p.id_parent, p.nom_parent, p.email_parent, p.tel_parent, c.etat, c.date_cmd, c.id_commande 
	FROM Parent as p, Commande as c 
	WHERE p.id_parent = c.id_parent 
	AND p.id_parent = '.$_SESSION['id_parent'].' ORDER BY c.id_commande ASC';
$db->DB_query($requete);

if ($db->DB_count() > 0)
{
	if ($db->DB_count() == 1)
	{
		?>
		<p><a class="btn" id="suivi_commande" value="suivi_commande" href="../suivi/index.php">Suivi de ma commande</a></p>
		<?php
	}
	else
	{
		?>
		<p><a class="btn" id="suivi_commande" value="suivi_commande" href="../suivi/index.php">Suivi de mes commandes</a></p>
		<?php
	}
}
?>

<br>
<table>
	<form method="get" action="index.php">
		<tr>
		<td><label class="compte" for="nom">Nom :</label></td>
		<td><input type="text" name="nom" id="nom" value="<?php echo $_SESSION["nom_parent"]; ?>" disabled/></td>
		<td><a href="modif_compte.php?compte=nom"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="email">E-mail :</label></td>
		<td><input type="text" name="email" id="email" value="<?php echo $_SESSION["email"]; ?>" disabled/></td>
		<td><a href="modif_compte.php?compte=email"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="tel">Tel:</label></td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $_SESSION["tel_parent"]; ?>" disabled/></td>
		<td><a href="modif_compte.php?compte=tel"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="mdp">Mot de passe:</label></td>
		<td><input type="password" name="mdp" id="mdp" value="" disabled/></td>
		<td><a href="modif_compte.php?compte=mdp"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="nbrenfant">Nombre d'enfants:</label></td>
		<td><input type="text" name="nbrenfant" id="nbrenfant" value="<?php echo $_SESSION["nb_enfants"]; ?>" disabled/></td>
		<td><a href="modif_compte.php?compte=enfant"><input type="button" value="Modifier"></a></td>
		</tr>
	</form>
</table>

</div></div>

<?php

require_once(INC.'/footer.inc.php');

?>