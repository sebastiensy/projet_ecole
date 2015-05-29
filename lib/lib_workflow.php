<?php

function affiche_workflow() 
{
	?>
	<MAP NAME="liens_workflow">
		<AREA SHAPE="rect" COORDS="123,182,285,225" HREF="../panier#ancrepanier">
		<AREA SHAPE="rect" COORDS="54,256,146,306" HREF="../accueil">
		<AREA SHAPE="rect" COORDS="157,258,290,305" HREF="../fournitures">
		<AREA SHAPE="rect" COORDS="70,340,269,389" HREF="../panier#btncmd">
	</MAP>
	<?php


	if (!empty($_SESSION['id_parent']))
	{
		/*
		*	pour afficher les infos sur les commandes
		*/
		$db = new DB_connection();
		$requete1 = 'SELECT * FROM Commande WHERE id_parent = '.$_SESSION['id_parent'].' AND etat < 5';
		$requete2 = 'SELECT * FROM Commande WHERE id_parent = '.$_SESSION['id_parent'].' AND etat = 5';

		$db->DB_query($requete1);
		$nbEnCours = $db->DB_count();

		$db->DB_query($requete2);
		$nbARetirer = $db->DB_count();


		/*
		*	pour afficher le workflow
		*/

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
		
		return "<div id=\"infocmd\"><span class=\"txtinfocmd\">Nombre de commande en cours : ".$nbEnCours."<br>Nombre de commande à retirer : ".$nbARetirer."</span></div>
		<img src=\"".$imageUrl."\" usemap=\"#liens_workflow\"></img>";
	}
	else
	{
		$imageUrl = "../../img/workflow.png";
		return "<img src=\"".$imageUrl."\" usemap=\"#liens_workflow\"></img>";
	}
}

?>