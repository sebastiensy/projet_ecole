<?php
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
?>

<!--<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />
		<script type="text/javascript">
		function subm()
		{
			document.getElementById('maj').submit();
		}
		
		</script>
		
	</head>
	
	<body>
	<style type="text/css">
		body {
			
			background-color: #FEF3DB;
			background-image:none;
			}
  </style>-->
  <?php $idListe=$_GET['idListe'];?>
		<br>
		<br>
		<div align="center" id="add-form">
		<form method="post" action="ajouter_article_liste1.php" id="maj">
		<input type="hidden" name="idListe" value="<?php echo $idListe ?>">
		<table width="75%" align="center">
			
			<tr >
				<td width="50%">
					<div align="Left">
						Référence du Materiel
					</div>
				</td>
				<td width="50%">
					<div align="center" >
						<select name="idMat">
							<option value=""></option>
						
							<?php 
								$db = new DB_connection();
								$req="select * from Materiel";
								$db->DB_query($req);
								while($ligne=$db->DB_object())
								{
							?>
									<option value="<?php echo $ligne->id_mat;?>"><?php echo $ligne->ref_mat;?></option>
							<?php
								}
							?>
			
						</select>
				</td>
			</tr>
			</table>
			<br>
			<table width="75%" align="center">
			<tr>
				<td width="50%">
					<div align="Left" >
						Quantité
					</div>
				</td>
				<td width="50%">
					<div align="center">
						<input type="number" name="qte">
					</div>
				</td>
			</tr>
			</table>
			<br>
			
			<table width="75%" align="center">
						<tr>
							<td><div align="right"><a href="#" onclick="subm();" class="myButton" id="sub">Valider</a></div></td>
						</tr>
			</table>
			</form>

<?php 
	require_once('../inc/footer.inc.php');
?>