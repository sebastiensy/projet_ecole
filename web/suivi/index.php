<?php

session_start();
require_once('../../inc/data.inc.php');
require_once(INC.'/droits.inc.php');

?>

<body onload="afficheWorkflow()" id="back">

	<div id="banner">
	</div>

	<div class="menu">

		<div id="connexion">
			<?php
				require_once("../connexion/login.php");
			?>
		</div>
		<div id="faq"><a href="../faq/"><img src="../../img/aide.png"></a></div>

		<div id="menu">

			<div id="menu1">
				<a href="../"><img src="../../img/menu/accueil.png"></a>
				<a href="../fournitures/"><img src="../../img/menu/article.png"></a>
				<?php 
				if(!isset($_SESSION['id_parent']))
				{
					?>
					<a href="../inscription/"><img src="../../img/menu/inscription.png"></a>
					<?php
				}
				else
				{
					?>
					<a href="../compte/"><img src="../../img/menu/compte.png"></a>
					<?php 
				}
				?>
				<a href="../contact/"><img src="../../img/menu/contact.png"></a>
			</div>

		</div>

		<div id="notification">
			<a href="../notification/"><img src="../../img/menu/messagerie.png"></a>
		</div>

		<div id="panier">
			<a href="../panier/"><img src="../../img/menu/panier.png"></a>
		</div>

		<?php 
				if(isset($_SESSION['droits']))
				{
					if ($_SESSION['droits'] ==1 )
					{
					?>
					<div id="admin">
						<a href="../admin/"><img src="../../img/menu/admin.png"></a>
					</div>
					<?php
					}
				}

		?>

	</div>

	<div class="corps">

		<div id="workflow">
		</div>

		<div id="page">

<?php

/*if ($_SESSION['id_parent'] != "")
{
		$db = new DB_connection();

$requete = 'SELECT p.id_parent, p.nom_parent, p.email_parent, p.tel_parent, c.etat, c.date_cmd, c.id_commande 
			FROM Parent as p, Commande as c 
			WHERE p.id_parent = c.id_parent 
			AND c.etat > 0 AND p.id_parent = '.$_SESSION['id_parent'].' ORDER BY c.id_commande DESC';
	$db->DB_query($requete);

	$nb_elems = 2;
	$nb_pages = ceil($db->DB_count() / $nb_elems);

	if(isset($_GET['page']))
	{
	     $pageActuelle = intval($_GET['page']);

	     if($pageActuelle > $nb_pages || $pageActuelle < 1)
	     {
	          $pageActuelle = 1;
	     }
	}
	else
	{
	     $pageActuelle=1;   
	}

	$premiereEntree=($pageActuelle-1)*$nb_elems;

	$requete .= ' LIMIT '.$premiereEntree.', '.$nb_elems.'';

	$db->DB_query($requete);

	if ($db->DB_count() > 0)
	{
		if ($db->DB_count() == 1)
			if (empty($_GET['page']))
				echo "<p class=\"titre\">Etat de ma commande</p>";
			else 
				echo "<p class=\"titre\">Etat de mes commandes</p>";
		else 
			echo "<p class=\"titre\">Etat de mes commandes</p>";

		?>
		<!--<form method="get" action="index.php">
			<p>
	 			<select name="liste">>
					<option value="0">Afficher toutes les commandes</option>
					<option value="1">En cours</option>
					<option value="2">Validé</option>
					<option value="3">Commande fournisseur</option>
					<option value="4">En cours de livraison</option>
					<option value="5">Livré</option>
					<option value="6">Retiré et payé</option>
	     		</select>
	 			<input type="submit" value="OK" title="valider" />
			</p>
		</form>-->
		<div id="suivcmds">
		<?php

		while($suiv = $db->DB_object())
		{
			$tmp = explode('-', $suiv->date_cmd);
			$date = $tmp[2].'/'.$tmp[1].'/'.$tmp[0];

			echo "<fieldset>";
			
			echo "<legend>Commande n°".$suiv->id_commande."</legend>";
			echo "<table width=\"300\">
					<tr>
						<th>Date de la commande : </th>
						<td>".$date."</td>
					</tr>
					<tr>
						<th>Contenu de la commande : </th>
						<td><a class=\"fancycmd\" value=\"commande".$suiv->nom_parent."\" href=\"commande.php?com=".$suiv->id_commande."\">Voir</a></td>
					</tr>
				</table>";
			echo "<a href='pdf.php?id=".$suiv->id_commande."' target='_blank'><img src='../../img/imprimer.png' id='impFacture' border='0'></a>";
			?>
			<div class="checkout-wrap">
		  		<ul class="checkout-bar">
		    		<li id="1" class="1"><div id="encours">En cours</div></li>
				    <li id="2" class="2"><div id="valide">Valide</div></li>
		    		<li id="3" class="3"><div id="cmdfourni">Commande fournisseur</div></li>
		    		<li id="4" class="4"><div id="eclivr">En cours de livraison</div></li>
		    		<li id="5" class="5"><div id="livre">Livre</div></li>
		    		<li id="6" class="6"><div id="rp">Retire et paye</div></li>
		    	</ul>
			</div>

		<?php 
			for ($i=1; $i<=6; $i++) 
			{	
				echo "<script type='text/javascript'>";
				echo "var i = ".$i.";";
				echo "if ($suiv->etat == i && $suiv->etat != 6)
				{
					$('.".$i."').removeClass().addClass('active');
				}
				else if ($suiv->etat >= i)
				{
					$('.".$i."').removeClass().addClass('visited');
				}
				else if ($suiv->etat < i)
				{
					$('.".$i."').removeClass().addClass('next');
				}
				else if ($suiv->etat == 6)
				{
					$('.".$i."').removeClass().addClass('visited');
				}"; 
				echo "</script>";

			}

			echo "<br><br><br><br><br>";

			echo "<table>
					<tr>
						<th>Parent : </th>
						<td>".$suiv->nom_parent."</td>
					</tr>
					<tr>
						<th></th>
						<td>".$suiv->email_parent."</td>
					</tr>
					<tr>
						<th></th>
						<td>".$suiv->tel_parent."</td>
					</tr>	
				</table>";

			echo "</fieldset>";
			echo "<br><br>";
		}
	}

	

	echo '</div>';

	// affichage des pages
	?>
	<div id="pages">
	<?php
	if($nb_pages > 1)
	{
		for($i=1; $i<=$nb_pages; $i++)
		{
	     	if($i==$pageActuelle)
	     	{
	         	echo "<span style=\"font-weight:bold; color:brown\">".$i."</span> | "; 
	     	}	
	     	else
	     	{
	        	echo '<a href="index.php?page='.$i.'">'.$i.'</a>';
	        	echo ' | ';
	     	}
		}
	}
	?>
	</div>

	<?php

	echo "</div></div>";

}
else
{
	header('location: ../accueil/index.php');
}*/

if(isset($_SESSION["id_parent"]))
{
	$db = new DB_connection();
	$requete = 'SELECT p.id_parent, p.nom_parent, p.email_parent, p.tel_parent, c.etat, c.date_cmd, c.id_commande 
		FROM Parent as p, Commande as c 
		WHERE p.id_parent = c.id_parent 
		AND c.etat > 0 AND p.id_parent = '.$_SESSION['id_parent'].' ORDER BY c.id_commande DESC';		

	$db->DB_query($requete);

	//
	$nb_elems = 10; // nombre d'éléments par page
	$nb_pages = ceil($db->DB_count() / $nb_elems);

	if(!empty($_GET["page"]))
	{
		$page = intval(htmlentities($_GET["page"], ENT_QUOTES));
		if($_GET["page"] > $nb_pages || $_GET["page"] < 1)
			$page = 1;
	}
	else
		$page = 1;

	$debut = ($page - 1) * $nb_elems;

	$requete .= ' LIMIT '.$debut.', '.$nb_elems.'';
	//

	$db->DB_query($requete);

	if($db->DB_count() > 0)
	{
		if ($db->DB_count() == 1)
			if (empty($_GET['page']))
				echo "<p class=\"titre\">Etat de ma commande</p>";
			else 
				echo "<p class=\"titre\">Etat de mes commandes</p>";
		else 
			echo "<p class=\"titre\">Etat de mes commandes</p>";
		?>
		<div id="suivcmds">
		<div class="liste">
		<table class="sortable" width="600" align="center">
			<tr>
				<td width="90"><div align="center">Commande</div></td>
				<td width="90"><div align="center">Date</div></td>
				<td width="90"><div align="center">Etat</div></td>
				<td width="40"><div align="center">Actions</div></td>
			</tr>
		<?php
		while($suivi = $db->DB_object())
		{
			echo "<tr>";
			echo "<td><div align=\"center\"><a class=\"fancyworkcmd\" href=\"etat.php?com=".$suivi->id_commande."\">Commande n°".$suivi->id_commande."</a></div></td>";
			
			$tmp = explode('-', $suivi->date_cmd);
			$date = $tmp[2].'/'.$tmp[1].'/'.$tmp[0];
			echo "<td><div align=\"center\">".$date."</div></td>";

			if ($suivi->etat == 1)
				echo "<td><div align=\"center\">En cours</div></td>";
			if ($suivi->etat == 2)
				echo "<td><div align=\"center\">Validé</div></td>";
			if ($suivi->etat == 3)
				echo "<td><div align=\"center\">Commande fournisseur</div></td>";
			if ($suivi->etat == 4)
				echo "<td><div align=\"center\">En cours de livraison</div></td>";
			if ($suivi->etat == 5)
				echo "<td><div align=\"center\">Livré</div></td>";
			if ($suivi->etat == 6)
				echo "<td><div align=\"center\">Retiré et payé</div></td>";

			echo '<td><div align="center"><a class="fancycmd" value="Afficher" href="commande.php?com='.$suivi->id_commande.'"><img title="Visualiser" src="../../img/visu.png"></a>';
			echo "<a href='pdf.php?id=".$suivi->id_commande."' target='_blank'><img src='../../img/imprimer.png' id='impFacture' border='0'></a></div></td>";

			echo "</tr>";
		}
		echo "</table></div></div>";
	}
	else
	{
		echo "<p>Vous n'avez aucune commande.</p>";
	}


	// affichage des pages
	?>
	<div id="pages">
	<?php
	if(isset($nb_pages))
	{
		if($nb_pages > 1)
		{
			for($i=1; $i <= $nb_pages; $i++)
			{
				if($i==$page)
				{
					echo "<span style=\"font-weight:bold; color:brown\">".$i."</span> | "; 
				}	
				else
				{
					echo '<a href="index.php?page='.$i.'">'.$i.'</a>';
					echo ' | ';
				}
			}
		}
	}
}
else
{
	header('location: ../accueil/index.php');
}

?>
</div></div></div>

<?php

require_once(INC.'/footer.inc.php');

?>