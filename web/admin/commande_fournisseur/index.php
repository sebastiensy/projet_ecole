<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<body>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<table width="900" align="center" class="entete">
			<tr>
				<td ><div align="right">Commande fournisseur</div></td>
			</tr>
		</table>

		<br>
		<table width="800" align="center" class="data">
			<tr>
				<th width="90" ><div align="center">Quantite</div></th>
				<th width="90" ><div align="center">Materiel</div></th>
				<th width="90" ><div align="center">Prix</div></th>
			</tr>

<?php

$requete1 = 'SELECT SUM(c.quantite), m.desc_mat, m.prix_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND com.id_commande = c.id_commande 
	AND com.etat >= 2
    GROUP BY c.id_mat';


	$db = new DB_connection();
	$db->DB_query($requete1);

	$prix = array();


?>


<?php

require_once('../inc/footer.inc.php');

?>