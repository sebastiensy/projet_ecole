<?php

function affiche_workflow($etat) 
{
	if (in_array($etat,array(2, 3)))
	{
		$imageUrl = "../../img/workflow_c.png";

		if(!empty($_SESSION['panier']) && !empty($_SESSION['liste']))
		{
			$imageUrl = "../../img/workflow_fl.png";
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

	echo "<script type=\"text/javascript\">$(\"#workflow\").css(\"background-image\", \"url(".$imageUrl.")\");</script>";

}

?>