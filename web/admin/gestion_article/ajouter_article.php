<?php
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
	require_once('../../../lib/lib_verifications.php');
	require_once('../../../lib/lib_form_ajout_article_admin.php');
?>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

		<script type="text/javascript" src="../../../js/ajout_article.js"></script>

		<table width="900" align="center" class="entete">
			<tr>
				<td ><div align="right">Ajouter des articles</div></td>
			</tr>
		</table>
		<br/><br/><br/><br/><br/><br/><br/><br/>

	<?php

		if (!isset($_POST['ref']) && !isset($_POST['desc']) && !isset($_POST['prix']))
		{
			formulaire_ajout_article("", "", "", ""); 
		}
		else
		{

			$db = new DB_connection();
				
			$req = "SELECT ref_mat FROM Materiel WHERE ref_mat = ".$_POST['ref'];
			$db->DB_query($req);
			

			if($ligne=$db->DB_object())
			{
				formulaire_ajout_article("<span style=\"color:red\"><p><strong>Le produit ayant pour reference ".$_POST['ref']." existe deja. Veuillez modifier la reference !</strong></p></span>",$_POST['ref'],$_POST['desc'],$_POST['prix']);
			}
			else
			{
				if(verifPrix($_POST['prix']))
				{
					$req1="insert into Sous_categorie values('','".$_POST['categorie']."','')";
					$db->DB_query($req1);
					$id=$db->DB_id();

					$req1="insert into Materiel (ref_mat, desc_mat, prix_mat, id_scat) values ('".$_POST['ref']."','".$_POST['desc']."','".$_POST['prix']."','".$id."')";
					$db->DB_query($req1);
					formulaire_ajout_article("<span style=\"color:green\"><p><strong>Le produit \"".$_POST['desc']."\" ayant pour reference ".$_POST['ref']." a bien ete ajoute.</strong></p></span>","","","");
				}
				else
				{
					formulaire_ajout_article("<span style=\"color:red\"><p><strong>Veuillez saisir un prix valide!</strong></p></span>",$_POST['ref'],$_POST['desc'],$_POST['prix']);
				}
			}
		}
	?> 
	
<?php 
	require_once('../inc/footer.inc.php');
?>		