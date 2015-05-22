<?php

function affiche_workflow() 
{
	if (!empty($_SESSION['id_parent']))
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
	//return $imageUrl;
	//echo "<script type=\"text/javascript\">$(\"#workflow\").css(\"background-image\", \"url(".$imageUrl.")\");</script>";
	return "<img src=\"".$imageUrl."\"></img>";
}

?>