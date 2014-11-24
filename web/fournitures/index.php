<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_fournitures.php');

?>

<body id="back">

	<div id="banner">
	</div>
	
	<div class="menu">
		<div id="menu">
			<div id="menu1">
				<a href="../"><img src="../../img/menu/acceuil.png"></a>
				<a href="../fournitures/"><img src="../../img/menu/article.png"></a>
				<a href="../inscription/"><img src="../../img/menu/inscription.png"></a>
				<a href="../contact/"><img src="../../img/menu/contact.png"></a>
				</div>
			</div>
	</div>
	<div id="page">

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
	?>

	</div>

<?php

require_once(INC.'/footer.inc.php');
		
?>