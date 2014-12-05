<?php  function formulaire_contacter($mail,$objet,$message){ ?>

<div id="formularie_contacte">
<form  action="contacte.php" method="POST"  >

<p><label class="lab_cont" for="email">Email :</label><input  class="in_cont" type="text" name="email" value="<?php echo $mail; ?>" /></p>
<p><label class="lab_cont" for="objet">Objet :</label><input class="in_cont" type="text" name="objet" value=" <?php echo $objet; ?>" /></p>


<p><label class="lab_cont" for="message">Votre text :</label><textarea id="idees" name="message"> <?php echo $message; ?></textarea></p>
<p > <input type="submit" name="ok" value="Envoyer" class="formb"/> <input type="reset" name="annuler" value="Annuler"  /></p>

</form>
</div>
<?php };?>