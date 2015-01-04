	<div id="formulaire"> 
 
<?php 

function formulaire_inscription($message="", $nom="", $email="", $tel="", $mdp="", $cmdp="", $nbrenfant="")
{ 

?> 
		<span style="color:red"><?php echo $message; ?></span>
		<form method="post" action="index.php">
		<p> <label class="inscription" for="nom">Nom :</label> <input type="text" name="nom" id="nom" onblur="verifPseudo(this)" value="<?php echo $nom;?>" /> </p>
		<p> <label class="inscription" for="email">E-mail :</label> <input type="text" name="email" id="email" onblur="verifMail(this)" value="<?php echo $email;?>" /></p>
		<p> <label class="inscription" for="tel">Tel:</label> <input type="text" name="tel" id="tel" onblur="verifTel(this)" value="<?php echo $tel;?>"/></p>
		<p> <label class="inscription" for="mdp">Mot de passe:</label> <input type="password" name="mdp" id="mdp" onblur="champVide(this)" value="<?php echo $mdp;?>" /></p>
		<p> <label class="inscription" for="cmdp">Confirmation du mot de passe:</label> <input type="password" name="cmdp" id="cmdp" onblur="champVide(this)" value="<?php echo $cmdp;?>"/></p>
		<p> <label class="inscription"  for="nbrenfant">Nombre d'enfants:</label> <input type="text" name="nbrenfant" id="nbrenfant" onblur="champVide(this)" class="spinner" min="1" max="10" value="<?php echo $nbrenfant;?>"/> </p>
		<p> <input class="b" type="submit" name="sinscrire" value="sinscire"> <input type="reset" name="annuler" value="annuler"></p>
		</form>
	</div>

<?php 

}

?>