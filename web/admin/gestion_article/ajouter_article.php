<?php
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
	require_once('../../../lib/lib_form_ajout_article_admin.php');
?>

<script type="text/javascript" src="../../../js/ajout_article.js"></script>

<table width="900" align="center" class="entete">
	<tr>
		<td ><div align="right">Ajouter des articles</div></td>
	</tr>
</table>
<br>
<br>
<br>
<br>


<div id="page">
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
				$req1="insert into Sous_categorie values('','".$_POST['categorie']."','')";
				$db->DB_query($req1);
				$id=$db->DB_id();

				$req1="insert into Materiel (ref_mat, desc_mat, prix_mat, id_scat) values ('".$_POST['ref']."','".$_POST['desc']."','".$_POST['prix']."','".$id."')";
				$db->DB_query($req1);
				formulaire_ajout_article("<span style=\"color:green\"><p><strong>Le produit \"".$_POST['desc']."\" ayant pour reference ".$_POST['ref']." a bien ete ajoute.</strong></p></span>","","","");
			}
		}

		?> 
	<!--<div id="msg">
		<?php 
			/*if (isset($_POST['ref']) && isset($_POST['desc']) && isset($_POST['prix']))
				{
					$db = new DB_connection();
				
					$req = "SELECT ref_mat FROM Materiel WHERE ref_mat = ".$_POST['ref'];
					$db->DB_query($req);
					

					if($ligne=$db->DB_object())
					{
						echo "	<span style=\"color:red\"><p><strong>Le produit ayant pour reference ".$_POST['ref']." existe deja. Veuillez modifier la reference !</strong></p></span>";

					}
					else
					{
						$req1="insert into Sous_categorie values('','".$_POST['categorie']."','')";
						$db->DB_query($req1);
						$id=$db->DB_id();

						$req1="insert into Materiel (ref_mat, desc_mat, prix_mat, id_scat) values ('".$_POST['ref']."','".$_POST['desc']."','".$_POST['prix']."','".$id."')";
						$db->DB_query($req1);
						echo "	<span style=\"color:green\"><p><strong>Le produit \"".$_POST['desc']."\" ayant pour reference ".$_POST['ref']." a bien été ajouté.</strong></p></span>";
					}
				}*/
		?>
	</div>
	<br>

		<div align="center" id="add-form">-->
		

		<!--<form method="post" action="ajouter_article.php" name="f1" id="maj">
		<table width="90%" align="center">
			<tr>
			<td >
			Reference
			</td>
			
			<td >
			Description
					
					</td>
					<td> Prix</td>  
			</tr>
					
			<tr >
				<td >
						<span><input type="text" name="ref" required></span>
				
				</td>
				<td >
					
								<span><input size="30" type="text" name="desc" required></span>
					
				</td>
				<td >
					
								<span><input size="10" type="text" name="prix" required></span>
					
				</td>
				
				</tr>
				<tr>
				<td colspan="3">
				Categorie <select name="categorie">
						<?php
						/*$db = new DB_connection();
						$req="select distinct categorie from Sous_categorie order by categorie asc";
						$db->DB_query($req);
						while($ligne=$db->DB_object())
						{*/
						?>
						<option value="<?php //echo $ligne->categorie;?>" > <?php //echo $ligne->categorie;?></option>
						<?php
						//}
						?>
						</select>
						</td>
						</tr>
	  
				<tr><td><div align="right" colspan=3><input type="submit" name="Valider"></div></td></tr>
				
			
			</table>
			</form>-->

<!--<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />-->
		<!--<script type="text/javascript">
		function subm()
		{
			
			document.getElementById('maj').submit();
			
		}
		
		</script>
			<script type="text/javascript" >
		function verif()
		{
			var ref=document.f1.ref.value;
			if(ref=="")
			{
				alert("Veuillez Entrer une reference");
				document.f1.ref.focus();
				return false();
			}
			var desc=document.f1.desc.value;
			if(desc=="")
			{
				alert("Veuillez Entrer une Description");
				document.f1.desc.focus();
				return false();
			}
			var prix=document.f1.desc.value;
			if(prix=="" || isNaN(prix)
			{
				alert("Veuillez Entrer un prix par unite");
				document.f1.prix.focus();
				return false();
			}
			
			}
			</script>-->
	<!--</head>
	
	<body>
	<style type="text/css">
		body {
			
			/*background-color: #FEF3DB;*/
			background-image:none;
			}
  </style>-->
		
<?php 
	require_once('../inc/footer.inc.php');
?>		