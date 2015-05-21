<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<script type="text/javascript">
function subm()
{
	document.getElementById('maj').submit();
}
</script>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>

	<div id="page">

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

		<table width="900" align="center" class="entete">
			<tr>
				<td ><div align="right">Modifier des articles</div></td>
			</tr>
		</table>
		<br/><br/><br/><br/><br/><br/><br/><br/>

		<div align="center" id="add-form">
		<form method="post" action="modif_article.php?p=recherche" id="maj">
			<table width="90%" align="center">
				<tr>
					<td width="40%">Référence</td>
					<td width="50%">Description</td>
					<td></td>  
				</tr>
				<tr>
					<td width="40%"><div align="Left"><span><input type="text" name="ref"></span></div></td>
					<td width="50%"><span><input type="text" name="desc"></span></td>
					<span><td><div align="right"><a href="#" onclick="subm();" class="myButton" id="sub">Rechercher</a></div></td><input style="font-size:0px; width:0px; height:0px;border:0px;padding:0px;" type="submit" value="" name="sub"/></span>
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

if(isset($_GET['p']))
{
	if($_GET['p']=="recherche")
	{
		echo '<br/><br/><table class="data" width="90%" align="center">';
		echo '<tr>';
			echo '<th>Référence</th>';
			echo '<th>Description</th>';
			echo '<th>Prix</th>';
			echo '<th>Supprimer</th>';
		echo '</tr>';
		while($ligne=$db->DB_object())
		{
			echo '<tr><td width="10%"><div align="center">';
			echo $ligne->ref_mat;
			echo '</div>';
			echo '</td><td width="60%"><div align="center"><form method="post" action="modif_article1.php?p=modif_desc&ref='.$ligne->ref_mat.'" >
			<div><input size=50 type=text name="desc" value="'.$ligne->desc_mat.'" >			
			<INPUT border=0 src="../../../img/icon_OK.png" type=image Value=submit ></div></form></div></td>';
			
			echo '<td width="30%"><div align="center"><form method="post" action="modif_article1.php?p=modif_prix&ref='.$ligne->ref_mat.'&prix='.$ligne->prix_mat.'&id='.$ligne->id_mat.'" >
			<div><input size=10 type=text name="pr" value="'.$ligne->prix_mat.'">			
			<INPUT border=0 src="../../../img/icon_OK.png" type=image Value=submit></div></form></div></td>';
			echo '<td width="5%"><div align="center"><form method="post" action="modif_article1.php?p=delete&ref='.$ligne->ref_mat.'&prix='.$ligne->prix_mat.'&id='.$ligne->id_mat.'" >
			<INPUT border=0 src="../../../img/del.png" type=image Value=submit></div></form></div></td>';
			echo '</tr>';
		}
		echo '</table>';
	}
}

?>

<?php

require_once('../inc/footer.inc.php');

?>