<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<?php

$id=$_GET['idListe'];
$db = new DB_connection();
/*                                       Modification du Niveau                                                    */
if($_GET['p']=="modif_niv")
{
	$req="update Liste_niveau set niveau='".$_POST['niv']."' where id_nivliste='".$id."'";
	$db->DB_query($req);
}
/*                                      Modification du prix d'une liste 										   */
if($_GET['p']=="modif_for")
{
	$req="update Liste_niveau set forfait='".$_POST['for']."' where id_nivliste='".$id."'";
	$db->DB_query($req);
}
/*                                      Modification d'un article										   */
if($_GET['p']=="modif_qte")
{
	//$ref=$_GET['ref'];
	$idMat=$_GET['idMat'];
	$qte=$_POST['qtte'];
	/*                             Récuperer La quantité de produit avant l'écraser                                 */
	//$req="select qte_scat from Compose where ref_mat='".$ref."' and id_nivListe=".$id;
	$req="select qte_scat from Compose where id_mat='".$idMat."' and id_nivListe=".$id;
	$db->DB_query($req);
	$ligne=$db->DB_Object();
	$qtea=$ligne->qte_scat;
	/*                            Récupere Le prix par unité du produit                                    */
	$req="select prix_mat from Materiel where id_mat='".$idMat."'";
	$db->DB_query($req);
	$ligne=$db->DB_Object();
	$prix=$ligne->prix_mat;
	/*                            Récuperer Le forfait                                                      */
	$req="select forfait from Liste_niveau where id_nivListe='".$id."'";
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
	
	$req="update Liste_niveau set forfait='".$for."' where id_nivListe=".$id;
	$db->DB_query($req);
	//$req="update Compose set qte_scat=".$_POST['qtte']." where id_nivListe='".$id."' and ref_mat='".$ref."'";
	$req="update Compose set qte_scat=".$_POST['qtte']." where id_nivListe='".$id."' and id_mat='".$idMat."'";
	$db->DB_query($req);
}
if($_GET['p']=="del_art")
{
	//$ref=$_GET['ref'];
	$idMat=$_GET['idMat'];
	/*                             Récuperer La quqtité de produit avant l'écraser                                 */
	//$req="select qte_scat from Compose where ref_mat='".$ref."' and id_nivListe=".$id;
	$req="select qte_scat from Compose where id_mat='".$idMat."' and id_nivListe=".$id;
	$db->DB_query($req);
	$ligne=$db->DB_Object();
	$qtea=$ligne->qte_scat;
	/*                            Récupere Le prix par unité du produit                                    */
	//$req="select prix_mat from Materiel where ref_mat='".$ref."'";
	$req="select prix_mat from Materiel where id_mat='".$idMat."'";
	$db->DB_query($req);
	$ligne=$db->DB_Object();
	$prix=$ligne->prix_mat;
	/*                            Récuperer Le forfait                                                      */
	$req="select forfait from Liste_niveau where id_nivListe='".$id."'";
	$db->DB_query($req);
	$ligne=$db->DB_Object();
	$for=$ligne->forfait;
	
	/*                             Modifier la valeur du forfait                                             */
	$for=$for-($qtea*$prix);
	$req="update Liste_niveau set forfait='".$for."' where id_nivListe=".$id;
	$db->DB_query($req);
	//$req="delete from Compose  where id_nivliste='".$id."' and ref_mat='".$ref."'";
	$req="delete from Compose  where id_nivliste='".$id."' and id_mat='".$idMat."'";
	
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