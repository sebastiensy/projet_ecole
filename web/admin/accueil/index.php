<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<body>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<div id="text" align="center">
			<br/><br/>
			Bienvenue Dans L'interface Administrateur
		</div>

<?php

require_once('../inc/footer.inc.php');

?>