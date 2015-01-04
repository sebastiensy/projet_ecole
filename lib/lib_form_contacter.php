<?php  

function formulaire_contacter($mail, $objet, $message)
{ 

	?>

	<div id="formulaire_contacte">
		<form  action="index.php" method="post" >

		<p><label class="lab_cont" for="email">Email :</label><input  class="in_cont" type="text" name="email" onblur="verifMail(this)" value="<?php echo $mail;?>" /></p>
		<p><label class="lab_cont" for="objet">Objet :</label><input class="in_cont" type="text" name="objet" onblur="champVide(this)" value="<?php echo $objet;?>" /></p>

		<p><label class="lab_cont" for="message">Texte :</label><textarea id="idees" name="message" onblur="champVide(this)" maxlength="256"><?php echo $message;?></textarea></p>
		<p > <input type="submit" name="ok" value="Envoyer" class="formb"/> <input type="reset" name="annuler" value="Annuler"  /></p>

		</form>
	</div>

	<?php 

}

?>