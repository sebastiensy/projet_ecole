<?php
$id=$_GET['id'];

require_once('../../inc/data.inc.php');
function get_niveau($code)
{
	$req="select libelle from niveau where code='".$code."'";
	$db = new DB_connection();
	$db->DB_query($req);
	if($ligne=$db->DB_object())
	{
		return $ligne->libelle;
	}
}
function charger_les_niveaux($code)
{
	
}

?>
<html>
<head>
<title>Interface Admin:Gestion des Listes</title>
<link rel="stylesheet" type="text/css" href="../../css/style_page.css" /> 

<link rel="stylesheet" type="text/css" href="../../css/style1.css" /> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="../../js/fancybox/source/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="../../js/fancybox/source/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
	
		$( document ).ready(function() {
			$("#fancy").fancybox({
				
				type: "iframe",
				width: '40%',
				height: '40%',
				onClosed: function() {   
     parent.location.reload(true); 
    ;}
								});
	});
</script>
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

<table width="900" align="center"class="entete">
<tr>
<td><div align="right">Modification de la liste <?php echo $id;?></div></td>
</tr>
</table>
<br>
<br>
<br>
<br>



<?php
$db = new DB_connection();
$req="select * from liste_niveau where id_nivliste=".$id;
$db->DB_query($req);
//$mysql_result=mysql_query($req,$connexion) or die("<br/><br/>".mysql_error());
$ligne=$db->DB_object();
if($ligne!=NULL)
{
?>
<div align="center" >
<fieldset align="center" class="gen"> 
	<legend>Infos Liste <?php echo $id;?></legend>
	<div align="center">
	<br>
	<br>
		<fieldset align="center" class="sup">
			<legend>Infos Génerale</legend>
			<table class="infos" width="400" align="center">
			<tr>
			<form method="post" action="modif_liste1.php?p=modif_niv&id=<?php echo $id;?>" >
				<td width="50"><div align="center">Niveau:</div></td>
			
				<td width="100"><div align="center"><select name="niv"><option value="<?php echo $ligne->niveau;?>" selected ><?php echo get_niveau($ligne->niveau)?></option>
				
				<?php 
				$db = new DB_connection();
				$reqb="select * from niveau where code not like '".$ligne->niveau."'";
				$db->DB_query($reqb);
				while($ligneb=$db->DB_Object())
				{
				?>
				<option value="<?php echo $ligneb->code;?>" ><?php echo $ligneb->Libelle;?></option>
				<?php
				}
				?>
				</select>
				<div></td>
			
				<td width="50"><div align="right" ><INPUT border=0 src="../../img/icon_OK.png" type=image Value=submit align="middle" ><div></td>
			</form> 
			</tr>
			<tr>
			<form method="post" action="modif_liste1.php?p=modif_for&id=<?php echo $id;?>" >
				<td width="50"><div align="center">Forfait:</div></td>
				
				<td width="100"><div align="center"><input size="10" type=text name="for" value="<?php echo $ligne->forfait;?>" ><div></td>
				
				<td width="50"><div align="right" ><INPUT border=0 src="../../img/icon_OK.png" type=image Value=submit align="middle" ><div></td>
				
			</form>
			</tr>
			</table>
		</fieldset>
	</div>
	<div align="center">
	<br>
	<br>
		<fieldset align="center" class="sup">
			<legend>Article</legend>
			<table class="data" align="center" width="500">
				<tr>
					<th width="30"><div align="center">Ref</div></th>
					<th width="250"><div align="center">Description</div></th>
					<th width="50"><div align="center">Prix/unité</div></th>
					<th width="100"><div align="center">Quantité</div></th>
					<th width="50"><div align="center">Supprimer</div></th>
				</tr>
				<?php 
					$db1 = new DB_connection();
					$req1="select * from Compose where id_nivliste=".$id;
					$db1->DB_query($req1);
					//$mysql_result1=mysql_query($req1,$connexion) or die ('Could not connect: ' . mysql_error());
					while($ligne1=$db1->DB_object())
					{
						$db2 = new DB_connection();
						$req2="select * from Materiel where ref_mat='".$ligne1->ref_mat."'";
						$db2->DB_query($req2);
						//$mysql_result2=mysql_query($req2,$connexion);
						$ligne2=$db2->DB_object();
						?>
						<tr>
							<td width="30"><div align="center"><?php echo $ligne1->ref_mat;?></div></td>
							
							<td width="250"><div align="center"><?php echo $ligne2->desc_mat;?></div></td>
							
							<td width="50"><div align="center"><?php echo $ligne2->prix_mat;?></div></td>
							
							<td width="100">
								<form method="post" action="modif_liste1.php?p=modif_qte&id=<?php echo $id;?>&ref=<?php echo $ligne1->ref_mat;?>" >
								<div align="left">
									<input type="number"  name="qtte" value="<?php echo $ligne1->qte_scat;?>">
									<INPUT border=0 src="../../img/icon_OK.png" type=image Value=submit  >
								</div>
								</form>
								
							</td>
							
							<td width="50"><div align="center">
							<form method="post" action="modif_liste1.php?p=del_art&id=<?php echo $id;?>&ref=<?php echo $ligne1->ref_mat;?>" >
								<INPUT border=0 src="../../img/del.png" type=image Value=submit  ></form> </div></td>
							
						<tr>
					<?php 
					}
					}
					?>
					
					</table>
					<table width="500" align="center">
						<tr>
							<td><div align="right"><a id="fancy" data-fancybox-type="iframe" href="ajouter_article_liste.php?id=<?php echo $id;?>" class="myButton">Ajouter Un Article</a></div></td>
						</tr>
					</table>
				</fieldset>
			</div>
	</fieldset>
</div>
</body>
</html>
