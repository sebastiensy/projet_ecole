<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');
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
		<br/>

<?php

if (!isset($_POST['ref']) && !isset($_POST['desc']) && !isset($_POST['prix']))
{
	formulaire_ajout_article("", "", "", ""); 
}
else
{
	$db = new DB_connection();
		
	$req = "SELECT ref_mat FROM Materiel WHERE ref_mat = ".$db->quote($_POST['ref']);
	$db->DB_query($req);

	if($ligne=$db->DB_object())
	{
		formulaire_ajout_article("<span style=\"color:red\"><p><strong>Le produit ayant pour référence ".htmlentities($_POST['ref'], ENT_QUOTES)." existe déjà. Veuillez modifier la référence !</strong></p></span>",htmlentities($_POST['ref'], ENT_QUOTES),htmlentities($_POST['desc'], ENT_QUOTES),htmlentities($_POST['prix'], ENT_QUOTES));
	}
	else
	{
		if(verifPrix($_POST['prix']))
		{
			$req1="insert into Sous_categorie values('','".$db->quote($_POST['categorie'])."','')";
			$db->DB_query($req1);
			$id=$db->DB_id();

			$req1="insert into Materiel (ref_mat, desc_mat, prix_mat, id_scat) values ('".$db->quote($_POST['ref'])."','".$db->quote($_POST['desc'])."','".$db->quote($_POST['prix'])."','".$id."')";
			$db->DB_query($req1);
			formulaire_ajout_article("<span style=\"color:green\"><p><strong>Le produit \"".htmlentities($_POST['desc'], ENT_QUOTES)."\" ayant pour référence ".htmlentities($_POST['ref'], ENT_QUOTES)." a bien été ajouté.</strong></p></span>","","","");
		}
		else
		{
			formulaire_ajout_article("<span style=\"color:red\"><p><strong>Veuillez saisir un prix valide!</strong></p></span>",htmlentities($_POST['ref'], ENT_QUOTES),htmlentities($_POST['desc'], ENT_QUOTES),htmlentities($_POST['prix'], ENT_QUOTES));
		}
	}
}

?>

<?php

require_once('../inc/footer.inc.php');

?>		