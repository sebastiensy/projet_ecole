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
$id_parent = 3;

session_start();

$_SESSION['id_parent'] = $id_parent;

$requete = 'SELECT p.id_parent, p.nom_parent, p.mdp_parent, p.email_parent, p.tel_parent, p.nb_enfants FROM Parent as p WHERE p.id_parent = '.$_SESSION['id_parent'];

$db = new DB_connection();
$db->DB_query($requete);

echo 'Mon compte';
?>

<?php 

while($parent = $db->DB_object())
{

?>

<p><a id="suivi_commande" value="suivi_commande" href="../suivi/index.php">Suivi de ma commande</a></p>

<form method="get" action="index.php">
		<p> <label class="compte" for="nom">Nom :</label> <input type="text" name="nom" id="nom" value="<?php echo $parent->nom_parent?>" disabled/> <a href="modif_compte.php?compte=nom"><input type="button" value="Modifier"></a></p>
		<p> <label class="compte" for="email">E-mail :</label> <input type="text" name="email" id="email"   value="<?php echo $parent->email_parent?>" disabled/> <a href="modif_compte.php?compte=email"><input type="button" value="Modifier"></a></p>
		<p> <label class="compte" for="tel">Tel:</label> <input type="text" name="tel" id="tel"    value="<?php echo $parent->tel_parent?>" disabled/> <a href="modif_compte.php?compte=tel"><input type="button" value="Modifier"></a></p>
		<p> <label class="compte" for="mdp">Mot de passe:</label> <input type="password" name="mdp" id="mdp"    value="<?php echo $parent->mdp_parent?>" disabled/> <a href="modif_compte.php?compte=mdp"><input type="button" value="Modifier"></a></p>
		<p> <label class="compte"  for="nbrenfant">Nombre d'enfants:</label> <input type="text" name="nbrenfant" id="nbrenfant" value="<?php echo $parent->nb_enfants?>" disabled/> <a href="modif_compte.php?compte=enfant"><input type="button" value="Modifier"></a></p>
		</form>

<?php 
}
?>


<?php


$db->DB_done();	

echo "</div>";


?>

<?php

require_once(INC.'/footer.inc.php');

?>