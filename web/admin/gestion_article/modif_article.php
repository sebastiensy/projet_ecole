<?php 
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
?>

<!--<html>
	<head>
		<title>Interface Administrateur:Modifier des articles</title>
		<link rel="stylesheet" type="text/css" href="../../../css/style_page.css" />
		<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />
		<style type="text/css">
			body{
				background-image:none;
				}
			
			
			</style>
	<head>
	<body>

<header class="tete">
			<img src="../../../img/header.jpg" alt="header">
		<header>-->
		<?php //require_once('../nav.php')?>
		<table width="900" align="center" class="entete">
<tr>
<td ><div align="right">Modifier des articles</div></td>
</tr>
</table>
<br>
<br>
<br>
<br>

<div id="page">

<br>
		<div align="center" id="add-form">
		<form method="post" action="modif_article.php?p=recherche" id="maj">
		
		<table width="90%" align="center">
			<tr>
			<td width="40%">
			Reference
			</td>
			
			<td width="50%">
			Description
					
					</td>
					<td></td>  
			</tr>
					
			<tr>
				<td width="40%">
					<div align="Left">
						<span><input type="text" name="ref"></span>
					</div>
				</td>
				<td width="50%">
					
								<span><input type="text" name="desc"></span>
					
				</td>
				<span><td><div align="right"><a href="#" onclick="subm();" class="myButton" id="sub">Rechercher</a></div></td></span>
				
			</tr>
			</table>
			</form>

<?php

if(isset($_GET['p']))
{
	if($_GET['p']=="recherche")
	{
		$req="select * from Materiel where";
		if(!empty($_POST["ref"]) && !empty($_POST["desc"]))
		{
			 $req.=" ref_mat ='".$_POST['ref']."' and desc_mat like '%".$_POST['desc']."%'";
			 //$req .= ' ref_mat = "'.$_POST["ref"].'" and desc_mat LIKE \'%'.$_POST["desc"].'%\'';
		}
		else if(!empty($_POST["ref"]))
		{
			$req.=" ref_mat ='".$_POST["ref"]."'";
		}
		else if(!empty($_POST["desc"]))
		{
			$req.=" desc_mat like '%".$_POST['desc']."%'";
			//$req .= ' desc_mat like \'%'.$_POST["desc"].'%\'';
		}
		else
		{
			$req.="1";
			}
	
		
		$db = new DB_connection();
		$db->DB_query($req);
		
		
	}
	
	}
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
			
			/*background-color: #FEF3DB;*/
			background-image:none;
			}
  </style>-->
		
			
		<?php
		if(isset($_GET['p']))
		{
			if($_GET['p']=="recherche")
			{
				echo '<table width="90%" align="center">';
				while($ligne=$db->DB_object())
				{
					echo '<tr><td width="10%">';
					echo $ligne->ref_mat;
					echo '</td><td width="60%"><form method="post" action="modif_article1.php?p=modif_desc&ref='.$ligne->ref_mat.'" >
					<div><input size=50 type=text name="desc" value="'.$ligne->desc_mat.'" >			
					<INPUT border=0 src="../../../img/icon_OK.png" type=image Value=submit ></div></form></td>';
					
					echo '<td width="30%"><form method="post" action="modif_article1.php?p=modif_prix&ref='.$ligne->ref_mat.'&prix='.$ligne->prix_mat.'" >
					<div><input size=10 type=text name="pr" value="'.$ligne->prix_mat.'">			
					<INPUT border=0 src="../../../img/icon_OK.png" type=image Value=submit></div></form></td>';
					echo '<td width="5%"><form method="post" action="modif_article1.php?p=delete&ref='.$ligne->ref_mat.'&prix='.$ligne->prix_mat.'" >
					<INPUT border=0 src="../../../img/del.png" type=image Value=submit></div></form></td>';
					echo '</tr>';
					}
					echo '</table>';
				}
				}
			?>

<?php 
	require_once('../inc/footer.inc.php');
?>