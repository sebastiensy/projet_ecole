<?php

function afficForm($message, $compte, $valeur=null)
{
	if(!empty($message))
	{
		?>
		<span style="color:red"><?php echo $message; ?></span>
		<?php
	}
	if($compte == "nom")
	{
		?>
		<form method="post" action="modif_compte.php">
		<p><label class="modif_compte" for="nom">Nom :</label><input type="text" name="nom_parent" value="<?php echo $valeur; ?>" onblur="verifPseudo(this)"/></p>
		<input type="submit" value="Enregistrer">
		</form>
		<?php
	}
	elseif($compte == "email")
	{
		?>
		<form method="post" action="modif_compte.php">
		<p><label class="modif_compte" for="email">Adresse email :</label><input type="text" name="email_parent" value="<?php echo $valeur; ?>" onblur="verifMail(this)"/></p>
		<input type="submit" value="Enregistrer">
		</form>
		<?php
	}
	elseif($compte == "tel")
	{
		?>
		<form method="post" action="modif_compte.php">
		<p><label class="modif_compte" for="tel">Numero de telephone :</label><input type="text" name="tel" value="<?php echo $valeur; ?>" onblur="verifTel(this)"/></p>
		<input type="submit" value="Enregistrer">
		</form>
		<?php
	}
	elseif($compte == "mdp")
	{
		?>
		<form method="post" action="modif_compte.php">
		<p><label class="modif_mdp" for="mdp">Mot de passe actuel :</label><input type="password" name="anc_mdp" onblur="verifMdp(this)"/></p>
		<p><label class="modif_mdp" for="mdp">Nouveau mot de passe :</label><input type="password" name="mdp1" onblur="verifMdp(this)"/></p>
		<p><label class="modif_mdp" for="mdp">Confirmation du mot de passe :</label><input type="password" name="mdp2" onblur="verifMdp(this)"/></p>
		<input type="submit" value="Enregistrer">
		</form>
		<?php
	}
	elseif($compte == "enfant")
	{
		?>
		<form method="post" action="modif_compte.php">
		<p><label class="modif_compte" for="enfant">Nombre d'enfants :</label><input type="number" size="1" min="1" max="20" name="enfant" value="<?php echo $valeur; ?>" onblur="verifEnfant(this)"/></p>
		<input type="submit" value="Enregistrer">
		</form>
		<?php
	}
}

?>