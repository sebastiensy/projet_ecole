<?php

function connexion()
{

	?>

	<!-- <div id="div_con">
		<form method="post" action="index.php">
		<p><label for="id" class="label_connexion">Adresse e-mail</label><input type="text" name="email" /></p>
		<p><label for="pass" class="label_connexion">Mot de passe</label><input type="password" name="pass" /></p>
		<p><input id="conbt" type="submit" name="connexion"></p>
		</form>
	</div> -->

	<?php

	session_start();
	$isLogged = 0;

	if(!isset($_SESSION['email']) && !isset($_SESSION['password'])) 
	{

	?>

		<form method="post" action="../connexion/login.php">
			<table id="co">
				<tr>
					<td>E-mail : </td>
				</tr>
				<tr>
					<td><input type="text" size="12" onblur="champVide(this)" name="email"/></td>
				</tr>
				<tr>
					<td>Mot de passe : </td>
				</tr>
				<tr>
					<td><input type="password" size="12" onblur="champVide(this)" name="pass"/></td>
				</tr>
				<tr>
					<td><input id="conbt" type="submit" name="connexion" value="Se connecter"></td>
				</tr>
			</table>
		</form>

	<?php

	}
	else
	{
		echo "<table id=\"co2\"><tr><td>Bienvenue, ".$_SESSION['email'];"</td></tr>";
		echo "<tr><td><a href=\"../deconnexion/logout.php\"/>Se d&eacute;connecter</a></td></tr></table>";
		$isLogged = 1;
	}

}

?>