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

// Pour test
$id_parent = 3;

session_start();

$_SESSION['id_parent'] = $id_parent;

$requete = 'SELECT p.nom_parent, p.id_parent, p.email_parent, p.tel_parent, c.etat, c.date_cmd, c.id_commande FROM Parent as p, Commande as c WHERE p.id_parent = c.id_parent AND p.id_parent = '.$_SESSION['id_parent'];

$db = new DB_connection();
$db->DB_query($requete);

echo 'Etat de ma commande';
?>


<div class="checkout-wrap">
  <ul class="checkout-bar">

    <li id="1" class="1">
      <!--<a href="#">En cours</a>-->
      En cours
    </li>
    
    <li id="2" class="2">Valide</li>
    
    <li id="3" class="3">Commande fournisseur</li>
    
    <li id="4" class="4">En cours de livraison</li>
    
    <li id="5" class="5">Livre</li>
       
  </ul>
</div>

<?php

while($suiv = $db->DB_object())
{
	/*echo "<script type='text/javascript'>";
	echo "$(document).ready(function() {
	alert('etat = ' + $suiv->etat);
	var i = 1;
	for(i;i<=5;i++)
	{
		if ($('.".i."').length > 0)
		alert('ok');
		if ($suiv->etat == i)
		{
			$('.i').removeClass().addClass('active');
		}
		else if ($suiv->etat <= i)
		{
			$('.i').removeClass().addClass('visited');
		}
		else if ($suiv->etat >= i)
		{
			$('.i').removeClass().addClass('next');
		}
	}
	});";
	echo "</script>";

	var file = '<?php echo $name; ?>';*/


	for ($i=1; $i<=5; $i++) 
	{	
		echo "<script type='text/javascript'>";
		echo "var i = ".$i.";";
		echo "if ($suiv->etat == i && $suiv->etat != 5)
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
		else if ($suiv->etat == 5)
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
/*echo "<table>
		<tr>
			<th>En cours de validation</th>
			<th>Valide</th>
			<th>Commande fournisseur</th>
			<th>En cours de livraison</th>
			<th>Livre</th>
		</tr>";*/

/*while($suiv = $db->DB_object())
{
	for ($i=1; $i<=5; $i++) {
		if($suiv->etat >= $i)
		{
			echo '<td><input type="checkbox" name="suivi'.$suiv->nom_parent.'" value="'.$i.'" checked></td>';
		}
		else
		{
			echo '<td><input type="checkbox" name="suivi'.$suiv->nom_parent.'" value="'.$i.'"></td>';
		}		
	}

	echo "</table>";

	echo "<br>";

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

}*/

//Jquery pour desactiver le clic si on ne met pas disabled dans les checkbox
/*echo "<script type='text/javascript'>";
echo "$('input:checkbox').click(function() { return false; });";
echo "</script>";*/

//session_unset ();
//session_destroy();


$db->DB_done();	

echo "</div>";
echo "</div>";


?>

<?php

require_once(INC.'/footer.inc.php');

?>