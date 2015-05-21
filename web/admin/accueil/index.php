<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<body>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<?php
		if(!isset($_SESSION['droits']))
		{
			header("Location: ../../index.php");
		}
		else
		{
			if($_SESSION['droits'] != 1)
			{
				header("Location: ../../index.php");
			}
		}
		?>

		<div id="text" align="center">
			<br/><br/>
			Bienvenue Dans L'interface Administrateur
		</div>

<?php

require_once('../inc/footer.inc.php');

?>