<?php

session_start();
require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');

?>

<?php

$idListe = $_GET['id'];

function get_niveau($code)
{
	$req = 'SELECT libelle from Niveau where code = "'.$code.'"';
	$db = new DB_connection();
	$db->DB_query($req);
	if($ligne=$db->DB_object())
	{
		return $ligne->libelle;
	}
}

?>

<div class="corps">

	<div id="menu">
		<?php
		require_once('../inc/menu.inc.php');
		?>
	</div>
	
	<div id="page">

		<table width="900" align="center"class="entete">
			<tr>
				<td><div align="right">Modification de la liste</div></td>
			</tr>
		</table>
		<br/><br/><br/><br/>

<?php

$db = new DB_connection();
$req = "select * from Liste_niveau where id_nivliste = ".$idListe;
$db->DB_query($req);
$ligne=$db->DB_object();
if($ligne != NULL)
{
	?>
	<div align="center" >
	<fieldset align="center" class="gen"> 
		<legend>Infos Liste</legend>
		<div align="center">
		<br/>
		<br/>
			<fieldset align="center" class="sup">
				<legend>Infos Générales</legend>
				<table class="infos" width="400" align="center">
				<tr>
				<form method="post" action="modif_liste1.php?p=modif_niv&idListe=<?php echo $idListe; ?>">
					<td width="50"><div align="center">Niveau:</div></td>
					<td width="100"><div align="center"><select name="niv"><option value="<?php echo $ligne->niveau; ?>" selected><?php echo get_niveau($ligne->niveau) ?></option>

					<?php 

					$db = new DB_connection();
					$reqb = "select * from Niveau where code not like '".$ligne->niveau."'";
					$db->DB_query($reqb);
					while($ligneb=$db->DB_Object())
					{
						?>
						<option value="<?php echo $ligneb->code; ?>"><?php echo $ligneb->Libelle; ?></option>
						<?php
					}

					?>

					</select>
					<div></td>
					<td width="50"><div align="right"><input border="0" src="../../../img/icon_OK.png" type="image" Value="submit" align="middle"><div></td>
				</form>
				</tr>

				<tr>
				<form method="post" action="modif_liste1.php?p=modif_for&idListe=<?php echo $idListe; ?>" >
					<td width="50"><div align="center">Forfait:</div></td>
					<td width="100"><div align="center"><input size="10" type="text" name="for" value="<?php echo $ligne->forfait; ?>" ><div></td>
					<td width="50"><div align="right" ><input border="0" src="../../../img/icon_OK.png" type="image" Value="submit" align="middle" ><div></td>
				</form>
				</tr>
				</table>
			</fieldset>

		</div>
		<div align="center">
		<br/>
		<br/>
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
						$req1 = "select * from Compose where id_nivliste = ".$idListe;
						$db1->DB_query($req1);
						while($ligne1=$db1->DB_object())
						{
							$db2 = new DB_connection();
							$req2 = 'select * from Materiel where id_mat= '.$ligne1->id_mat;
							$db2->DB_query($req2);
							$ligne2=$db2->DB_object();
						?>
							<tr>
								<td width="30"><div align="center"><?php echo $ligne2->ref_mat;?></div></td>
								<td width="250"><div align="center"><?php echo $ligne2->desc_mat;?></div></td>
								<td width="50"><div align="center"><?php echo $ligne2->prix_mat;?></div></td>
								<td width="100">
									<!-- <form method="post" action="modif_liste1.php?p=modif_qte&id=<?php /*echo $id;?>&ref=<?php echo $ligne2->ref_mat;*/?>" > -->
									<form method="post" action="modif_liste1.php?p=modif_qte&idListe=<?php echo $idListe;?>&idMat=<?php echo $ligne2->id_mat;?>">
									<div align="left">
										<input type="number"  name="qtte" value="<?php echo $ligne1->qte_scat;?>">
										<input border="0" src="../../../img/icon_OK.png" type="image" value="submit">
									</div>
									</form>
								</td>

								<td width="50"><div align="center">
								<!-- <form method="post" action="modif_liste1.php?p=del_art&id=<?php /*echo $id;?>&ref=<?php echo $ligne2->ref_mat;*/?>" > -->
								<form method="post" action="modif_liste1.php?p=del_art&idListe=<?php echo $idListe;?>&idMat=<?php echo $ligne2->id_mat;?>" >
								<input border="0" src="../../../img/del.png" type="image" value="submit"></form></div></td>
							<tr>
						<?php 
						}
}
	?>

					</table>
					<table width="500" align="center">
						<tr>
							<td><div align="right"><a id="fancy" data-fancybox-type="iframe" href="ajouter_article_liste.php?idListe=<?php echo $idListe;?>" class="myButton">Ajouter Un Article</a></div></td>
						</tr>
					</table>
				</fieldset>
			</div>
	</fieldset>

<?php

require_once('../inc/footer.inc.php');

?>