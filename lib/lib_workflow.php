<?php

function affiche_workflow() 
{
	if (!empty($_SESSION['id_parent']))
	{
		$imageUrl = "../../img/workflow_c.png";

		if(!empty($_SESSION['panier']) && !empty($_SESSION['liste']))
		{
			$imageUrl = "../../img/workflow_lf.png";
		}
		else if (!empty($_SESSION['liste']) && empty($_SESSION['panier']))
		{
			$imageUrl = "../../img/workflow_l.png";
		}
		else if (empty($_SESSION['liste']) && !empty($_SESSION['panier']))
		{
			$imageUrl = "../../img/workflow_f.png";
		}
	}
	else
	{
		$imageUrl = "../../img/workflow.png";
	}

	?>
	<MAP NAME="liens_workflow">
		<AREA SHAPE="rect" COORDS="123,182,285,225" HREF="../panier#ancrepanier">
		<AREA SHAPE="rect" COORDS="54,256,146,306" HREF="../accueil">
		<AREA SHAPE="rect" COORDS="157,258,290,305" HREF="../fournitures">
		<AREA SHAPE="rect" COORDS="70,340,269,389" HREF="../panier#btncmd">
	</MAP>
	
	<?php
	return "<img src=\"".$imageUrl."\" usemap=\"#liens_workflow\"></img>";
}

?>