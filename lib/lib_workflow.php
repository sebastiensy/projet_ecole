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

	return "<img src=\"".$imageUrl."\"></img>";
}

?>