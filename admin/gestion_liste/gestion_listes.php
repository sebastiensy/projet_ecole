<?php

require '../conf.php';



?>
<html>
<head>
<title>Interface Admin:Gestion des Listes</title>
<link rel="stylesheet" type="text/css" href="../../css/style_page.css" /> 
<link rel="stylesheet" type="text/css" href="../../css/style1.css" /> 
<style type="text/css">
			body{
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
						<li><a href="../gestion_liste">G&eacute;rer Les Listes</a></li>
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
<table width="900" align="center" class="entete">
<tr>
<td ><div align="right">Les Listes</div></td>
</tr>
</table>
<br>
<br>
<br>
<br>
<table width="900" align="center" class="data">
<tr>
<th width="20" ><div align="center">id</div></th>
<th width="90" ><div align="center">Niveau-Classe</div></th>
<th width="50" ><div align="center">Prix(forfait)</div></th>
<th width="50" ><div align="center">Modifier</div></th>
<th width="20" ><div align="center">Supprimer</div></th>
</tr>


<?php 
$req="select * from liste_niveau where 1";
$mysql_result=mysql_query($req,$connexion) or die('Could not connect: ' . mysql_error());
while($ligne=mysql_fetch_array($mysql_result))
{

?>

<tr>
<td width="20" ><div align="center"><?php echo $ligne['id_nivliste'];?></div></td>
<td width="90" ><div align="center"><?php echo $ligne['niveau'];?></div></td>
<td width="50" ><div align="center"><?php echo $ligne['forfait'];?></div></td>
<td width="50" ><div align="center"><a href="modif_liste.php?id=<?php echo $ligne['id_nivliste'];?>"> Modifier </a></div></td>
<td width="50" ><div align="center"><a href="del_liste.php?id="> <img src="../../img/del.png"> </a></div></td>
</tr>
<?php
}
?>
</table>
<br>
<table width="900" align="center">
<tr>
<td><div align="right"><a href="ajouter_liste.php?p=1" class="myButton">Ajouter Une liste</a></div></td>
</tr>
</table>
</body>
</html>

















