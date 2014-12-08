<?php

function connexion()
{

	?>

	<div id="div_con">
		<form method="post" action="index.php">
		<p><label for="id" class="label_connexion">Adresse e-mail</label><input type="text" name="email" /></p>
		<p><label for="pass" class="label_connexion">Mot de passe</label><input type="password" name="pass" /></p>
		<p><input id="conbt" type="submit" name="connexion"></p>
		</form>
	</div>

	<?php

}

?>