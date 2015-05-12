	<div id="formulaire"> 
 
<?php 

function formulaire_inscription($message="", $nom="", $email="", $tel="", $mdp="", $cmdp="", $nbrenfant="1")
{ 

?> 
		<span style="color:red"><?php echo $message; ?></span>
		<form method="post" action="index.php">
		<p> <label class="inscription" for="nom">Nom :</label> <input type="text" name="nom" id="nom" onblur="verifPseudo(this)" value="<?php echo $nom;?>" /> </p>
		<p> <label class="inscription" for="email">E-mail :</label> <input type="text" name="email" id="email" onblur="verifMail(this)" value="<?php echo $email;?>" /></p>
		<p> <label class="inscription" for="tel">Tel :</label> <input type="text" name="tel" id="tel" onblur="verifTel(this)" value="<?php echo $tel;?>"/></p>
		<p> <label class="inscription" for="mdp">Mot de passe :</label> <input type="password" name="mdp" id="mdp" onblur="verifMdp(this)" value="<?php echo $mdp;?>" /></p>
		<p> <label class="inscription" for="cmdp">Confirmation du mot de passe :</label> <input type="password" name="cmdp" id="cmdp" onblur="verifMdp(this)" value="<?php echo $cmdp;?>"/></p>
		<p> <label class="inscription" for="nbrenfant">Nombre d'enfants :</label> <input type="number" name="nbrenfant" id="nbrenfant" onblur="verifEnfant(this)" size="1" min="1" max="10" value="<?php echo $nbrenfant; ?>"/></p>
		<p> <input class="b" type="submit" name="sinscrire" value="Valider"> <input type="reset" name="annuler" value="Annuler"></p>
		</form>
	</div>

<?php 

}

?>