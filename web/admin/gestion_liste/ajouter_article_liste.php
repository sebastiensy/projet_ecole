<?php

session_start();
require_once('../inc/data.inc.php');

?>

<html>
	<head>
		<title>Interface Administrateur</title>
		<link rel="stylesheet" href="../../../css/myButton.css">
		<script type="text/javascript">
		function subm()
		{
			document.getElementById('maj').submit();
		}
		</script>
	</head>
	<body>

	<?php
	if(!isset($_SESSION['droits']))
	{
		header("Location: ../../index.php");
	}
	else
	{
		if($_SESSION['droits'] != 1)
		{
			header("Location: ../../index.php");
		}
	}
	?>

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