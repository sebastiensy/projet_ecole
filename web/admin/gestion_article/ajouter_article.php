<?php

require_once('../inc.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />
		<script type="text/javascript">
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
			</script>
	</head>
	
	<body>
	<style type="text/css">
		body {
			
			background-color: #FEF3DB;
			background-image:none;
			}
  </style>
		<br>
		<div align="center" id="add-form">
		<form method="post" action="ajouter_article1.php" name="f1" onSubmit="return verif()" id="maj">
		
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
						$db = new DB_connection();
						$req="select distinct categorie from Sous_categorie order by categorie asc";
						$db->DB_query($req);
						while($ligne=$db->DB_object())
						{
						?>
						<option value="<?php echo $ligne->categorie;?>" > <?php echo $ligne->categorie;?></option>
						<?php
						}
						?>
						</select>
						</td>
						</tr>
	  
				<tr><td><div align="right" colspan=3><input type="submit" name="Valider"></div></td></tr>
				
			
			</table>
			</form>
		
		</div>	
					
			
	</body>
	<script >
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
			</script>