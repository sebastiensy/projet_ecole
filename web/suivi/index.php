<?php

require_once('../../inc/data.inc.php');

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
	
	<div class="corps">
	<div id="page">

	

<?php

session_start();

	if ($_SESSION['id_parent'] != "")
	{
	$requete = 'SELECT p.nom_parent, p.id_parent, p.email_parent, p.tel_parent, c.etat, c.date_cmd, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND p.id_parent = '.$_SESSION['id_parent'];

	$db = new DB_connection();
	$db->DB_query($requete);

	echo 'Etat de ma commande';
	?>

<input type="button" name="btn_print" value="Imprimer" onclick="print(true);"> 
	<div class="checkout-wrap">
	  <ul class="checkout-bar">

	    <li id="1" class="1">En cours</li>
	    
	    <li id="2" class="2">Valide</li>
	    
	    <li id="3" class="3">Commande fournisseur</li>
	    
	    <li id="4" class="4">En cours de livraison</li>
	    
	    <li id="5" class="5">Livre</li>

	    <li id="6" class="6">Retire et paye</li>
	       
	  </ul>
	</div>

	<?php

	while($suiv = $db->DB_object())
	{
		for ($i=1; $i<=6; $i++) 
		{	
			echo "<script type='text/javascript'>";
			echo "var i = ".$i.";";
			echo "if ($suiv->etat == i && $suiv->etat != 6)
			{
				$('#".$i."').removeClass().addClass('active');
			}
			else if ($suiv->etat >= i)
			{
				$('#".$i."').removeClass().addClass('visited');
			}
			else if ($suiv->etat < i)
			{
				$('#".$i."').removeClass().addClass('next');
			}
			else if ($suiv->etat == 6)
			{
				$('#".$i."').removeClass().addClass('visited');
			}"; 
			echo "</script>";

		}

		echo "<br><br><br><br><br><br>";

		echo "<table>
				<tr>
					<th>Numero de commande</th>
					<td>".$suiv->id_commande."</td>
				</tr>
				<tr>
					<th>Date de la commande</th>
					<td>".$suiv->date_cmd."</td>
				</tr>
			</table>";

		echo "<br>";

		echo "<table>
				<tr>
					<th>Parent</th>
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
		
	}


	$db->DB_done();	

	echo "</div>";
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