<?php

require_once('../../inc/data.inc.php');

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

<?php

// Pour test
//$id_parent = 3;

if(!isset($_SESSION["id_parent"]))
{
	header("Location: ../index.php");
}

$requete = 'SELECT p.id_parent, p.nom_parent, p.mdp_parent, p.email_parent, p.tel_parent, p.nb_enfants FROM Parent as p WHERE p.id_parent = '.$_SESSION['id_parent'];

$db = new DB_connection();
$db->DB_query($requete);

?>

<p class="titre">Mon compte</p>

<?php 

while($parent = $db->DB_object())
{

?>

<p><a id="suivi_commande" value="suivi_commande" href="../suivi/index.php">Suivi de ma commande</a></p>

<table>
	<form method="get" action="index.php">
		<tr>
		<td><label class="compte" for="nom">Nom :</label></td>
		<td><input type="text" name="nom" id="nom" value="<?php echo $parent->nom_parent?>" disabled/></td>
		<td><a href="modif_compte.php?compte=nom"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="email">E-mail :</label></td>
		<td><input type="text" name="email" id="email" value="<?php echo $parent->email_parent?>" disabled/></td>
		<td><a href="modif_compte.php?compte=email"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="tel">Tel:</label></td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $parent->tel_parent?>" disabled/></td>
		<td><a href="modif_compte.php?compte=tel"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="mdp">Mot de passe:</label></td>
		<td><input type="password" name="mdp" id="mdp" value="" disabled/></td>
		<td><a href="modif_compte.php?compte=mdp"><input type="button" value="Modifier"></a></td>
		</tr>
		<tr>
		<td><label class="compte" for="nbrenfant">Nombre d'enfants:</label></td>
		<td><input type="text" name="nbrenfant" id="nbrenfant" value="<?php echo $parent->nb_enfants?>" disabled/></td>
		<td><a href="modif_compte.php?compte=enfant"><input type="button" value="Modifier"></a></td>
		</tr>
	</form>
</table>

<?php 
}
?>


<?php


$db->DB_done();	

echo "</div>";
echo "</div>";


?>

<?php

require_once(INC.'/footer.inc.php');

?>