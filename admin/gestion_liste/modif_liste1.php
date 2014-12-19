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
		/*                             Récuperer La quqtité de produit avant l'écraser                                 */
		$req="select qte_scat from compose where ref_mat='".$ref."' and id_nivListe=".$id;
		$db->DB_query($req);
		$ligne=$db->DB_Object();
		$qtea=$ligne->qte_scat;
		/*                            Récupere Le prix par unité du produit                                    */
		$req="select prix_mat from materiel where ref_mat='".$ref."'";
		$db->DB_query($req);
		$ligne=$db->DB_Object();
		$prix=$ligne->prix_mat;
		/*                            Récuperer Le forfait                                                      */
		$req="select forfait from liste_niveau where id_nivListe='".$id."'";
		$db->DB_query($req);
		$ligne=$db->DB_Object();
		$for=$ligne->forfait;
		/*                             nouvelle quantité > ancienne quantité                                     */
		if($qte>$qtea)
		{
			$res=$qte-$qtea;
			$for=$for+($prix*$res);
		}
		else
		{
			$res=$qtea-$qte;
			$for=$for-($prix*$res);
		}
		
		$req="update liste_niveau set forfait='".$for."' where id_nivListe=".$id;
		$db->DB_query($req);
		$req="update Compose set qte_scat=".$_POST['qtte']." where id_nivListe='".$id."' and ref_mat='".$ref."'";
		//echo $req;
		$db->DB_query($req);
	}
	if($_GET['p']=="del_art")
	{
		$ref=$_GET['ref'];
		/*                             Récuperer La quqtité de produit avant l'écraser                                 */
		$req="select qte_scat from compose where ref_mat='".$ref."' and id_nivListe=".$id;
		$db->DB_query($req);
		$ligne=$db->DB_Object();
		$qtea=$ligne->qte_scat;
		/*                            Récupere Le prix par unité du produit                                    */
		$req="select prix_mat from materiel where ref_mat='".$ref."'";
		$db->DB_query($req);
		$ligne=$db->DB_Object();
		$prix=$ligne->prix_mat;
		/*                            Récuperer Le forfait                                                      */
		$req="select forfait from liste_niveau where id_nivListe='".$id."'";
		$db->DB_query($req);
		$ligne=$db->DB_Object();
		$for=$ligne->forfait;
		
		/*                             Mofifier la valeur du forfait                                             */
		$for=$for-($qtea*$prix);
		$req="update liste_niveau set forfait='".$for."' where id_nivListe=".$id;
		$db->DB_query($req);
		$req="delete from Compose  where id_nivliste='".$id."' and ref_mat='".$ref."'";
		
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