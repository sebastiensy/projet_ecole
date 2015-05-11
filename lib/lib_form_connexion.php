<?php

function connexion()
{
	session_start();

	if(!isset($_SESSION['email']) && !isset($_SESSION['password'])) 
	{

	?>

		<form method="post" action="../connexion/login.php">
			<table id="co">
				<tr>
					<td>E-mail : </td>
				</tr>
				<tr>
					<td><input type="text" size="12" onblur="verifMail(this)" name="email"/></td>
				</tr>
				<tr>
					<td>Mot de passe : </td>
				</tr>
				<tr>
					<td><input type="password" size="12" onblur="verifMdp(this)" name="pass"/></td>
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
	}
}

?>