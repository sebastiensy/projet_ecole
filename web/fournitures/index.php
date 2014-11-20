<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_fournitures.php');

?>

<body>
	<?php
		// test :
		// http://localhost/projet_ecole/web/fournitures/index.php?cat=ECRITURE&scat=SURLIGNEURS
		if(!empty($_GET["cat"]))
		{
			if(!empty($_GET["scat"]))
			{
				afficherFournitures($_GET["cat"], $_GET["scat"]);
			}
			else
			{
				afficherFournitures($_GET["cat"]);
			}
		}
		else
		{
			afficherFournitures();
		}
		require_once(INC.'/footer.inc.php');
	?>