<?php
require_once('../../inc/data.inc.php');
	$id=$_GET['id'];
	$db = new DB_connection();
	/*                                       Modification du Niveau                                                    */
	if($_GET['p']=="modif_niv")
	{
		$req="update liste_niveau set niveau='".$_POST['niv']."' where id_nivliste='".$id."'";
		//$myqsl_result=mysql_query($req,$connexion);
		$db->DB_query($req);
	}
	/*                                      Modification du prix d'une liste 										   */
	if($_GET['p']=="modif_for")
	{
		$req="update liste_niveau set forfait='".$_POST['for']."' where id_nivliste='".$id."'";
		//$myqsl_result=mysql_query($req,$connexion);
		$db->DB_query($req);
	}
	/*                                      Modification d'un article										   */
	if($_GET['p']=="modif_qte")
	{
		$ref=$_GET['ref'];
		$qte=$_POST['qtte'];
		//echo $qte;
		$req="update Compose set qte_scat=".$_POST['qtte']." where id_nivliste='".$id."' and ref_mat='".$ref."'";
		//echo $req;
		$db->DB_query($req);
	}
	if($_GET['p']=="del_art")
	{
		$ref=$_GET['ref'];
		
		
		$req="delete from Compose  where id_nivliste='".$id."' and ref_mat='".$ref."'";
		//echo $req;
		$db->DB_query($req);
	}
	
	$url="modif_liste.php?id=".$id;
	header("Refresh:0;url=$url");
	?>
	<html>
		<style type="text/css">
			body{
				background-image:none;
				}
				</style>
				</html>