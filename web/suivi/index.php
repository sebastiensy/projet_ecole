<?php

require_once('../../inc/data.inc.php');

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

	if(!isset($_SESSION["id_parent"]))
	{
		header("Location: ../index.php");
	}

	if ($_SESSION['id_parent'] != "")
	{
	$requete = 'SELECT p.id_parent, p.nom_parent, p.email_parent, p.tel_parent, c.etat, c.date_cmd, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND p.id_parent = '.$_SESSION['id_parent'];

	$db = new DB_connection();
	$db->DB_query($requete);

	$nb_elems = 2; // nombre d'éléments par page
	$nb_pages = ceil($db->DB_count() / $nb_elems);

	$debut = 1;

	$requete .= ' LIMIT '.$debut.', '.$nb_elems.'';

	echo $requete;
	$db->DB_query($requete);



	echo "<p class=\"titre\">Etat de ma (mes) commande(s)</p>";
	?>

	

	<?php

	if ($db->DB_count() > 0)
	{

		while($suiv = $db->DB_object())
		{
			
			echo "<fieldset>";
			
			echo "<legend>Commande n°".$suiv->id_commande."</legend>";
			echo "<table>
					<tr>
						<th>Date de la commande : </th>
						<td>".$suiv->date_cmd."</td>
					</tr>
				</table>";
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

	$db->DB_done();



	// affichage des pages
	?>
	<div id="pages">
	<?php if ($nb_pages > 1)
	{
		for($i=1; $i <= $nb_pages; ++$i)
		{
			echo "<span style=\"font-weight:bold; color:brown\"><a href=\"./index.php?page=".$i."\">".$i."</a></span> | ";
		}
	
	}
	?>
	</div>

	<?php

	echo "</div>";


	
}
else
{
	header('location: ../accueil/index.php');
}

?>

<?php

require_once(INC.'/footer.inc.php');

?>