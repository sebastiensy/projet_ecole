<?php

session_start();
require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');

?>

<html>
	<head>
		<title>Rentrée Facile</title>
		<link rel="icon" type="image/png" href="../../img/icone.png"/>
		<link rel="stylesheet" href="../../css/progress.bar.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	</head>
	<body>

<?php
if (isset($_GET['com']))
{
	$db = new DB_connection();

	$requete = 'SELECT p.id_parent, c.etat, c.date_cmd, c.id_commande 
			FROM Parent as p, Commande as c 
			WHERE p.id_parent = c.id_parent 
			AND c.etat > 0 AND p.id_parent = '.$_SESSION['id_parent'].' AND c.id_commande = '.$db->quote($_GET['com']);

	$db->DB_query($requete);
	if ($db->DB_count() > 0)
	{
		?>
		<div id="suiv">
		<?php

		while($suiv = $db->DB_object())
		{
			?>
			<div align="right" class="checkout-wrap">
		  		<ul class="checkout-bar">
		    		<li id="1" class="1"><div id="encours">En cours</div></li>
				    <li id="2" class="2"><div id="valide">Valid�</div></li>
		    		<li id="3" class="3"><div id="cmdfourni">Commande fournisseur</div></li>
		    		<li id="4" class="4"><div id="eclivr">En cours de livraison</div></li>
		    		<li id="5" class="5"><div id="livre">Livr�</div></li>
		    		<li id="6" class="6"><div id="rp">Retir� et pay�</div></li>
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
		}
	}
}

?>
</div>
</body>
</html>