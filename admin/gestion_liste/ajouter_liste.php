<?php require_once('../../inc/data.inc.php');?>
<html>
	<head>
		<title>Interface Admin:Gestion des Listes</title>
		<link rel="stylesheet" type="text/css" href="../../css/style1.css" /> 
		<link rel="stylesheet" type="text/css" href="../../css/style_page.css" />
		<script>
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}
</script>
<style type="text/css">
		body {
			
			
			background-image:none;
			}
  </style>
	</head>
	<body>
		<header class="tete">
			<img src="../../img/header.jpg" alt="header">
		<header>
		<nav class="menu">
			<br>
			<br>
			<br>
			<table width="150" align="left">
			<ul>
				<tr>
					<td>
						<br>
						<br>
						<li><a href="../">G&eacute;rer Les Listes</a></li>
						<br>
						<br>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<li>G&eacute;rer Les Articles</li>
						<br>
						<br>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<li>Suivre Les Commandes</li>
						<br>
						<br>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<li>Messagerie</li>
						<br>
						<br>
					</td>
				</tr>
			</ul>
			</table>
			</nav>
			<table width="900" align="center"class="entete">
				<tr>
					<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
				</tr>
			</table>
		<br>
		<br>
		<br>
		<br>
		<div align="center" id="content" >
<?php $i=$_GET['p'];
	  $db = new DB_connection();
	  $req="select distinct categorie from sous_categorie order by categorie asc";
	  $db->DB_query($req);
	  //$mysql_result=mysql_query($req,$connexion);
	  $cpt=1;
	  $cat;
	  while($ligne=$db->DB_object() and $cpt<=$i){
	  
	  $cat=$ligne->categorie;
	  $cpt++;
	  }
	  $db1 = new DB_connection();
	  $req1="select * from materiel where id_scat in (select id_scat from sous_categorie where categorie='".$cat."')";
	  $db1->DB_query($req1);
	  //$mysql_result1=mysql_query($req1,$connexion);
	  
?>
			
			
				<div id="steps">
					<fieldset align="center" class="gen">
					<legend>Choisir Les articles</legend>
					<div id="wrap">
					

					<div class="left">
					<fieldset class="wrap">
						<legend>Tout Les Articles</legend>
						<?php
						$cpta=0;					
						while($ligne1=$db1->DB_object())
								{
									?>
									<div id="drag1" draggable="true" ondragstart="drag(event)"><?php echo $ligne1->desc_mat.'-'.$ligne1->ref_mat;?></div>
						<?php
						$cpta++;
						}
						?>
						
					</fieldset>
					</div>
				
				<div class="right" >
					<fieldset class="wrap">
						<legend>Les Articles de la liste</legend>
						
						<?php 
						while($cpta>0)
						{
						?>
						<div class="wrap">
						<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
						<div id="div2"></div>
						</div>
						<?php
						$cpta--;
						}
						?>
					</fieldset>
					</div>
				
			</div>
			
		</fieldset>
			
		
		
	</body>
</html>