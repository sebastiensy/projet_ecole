<?php
require_once('../inc.php');
	$ref=$_GET['ref'];
	$db = new DB_connection();
	$db1 = new DB_connection();
	/*                                       Modification du Descriptif                                                    */
	if($_GET['p']=="modif_desc")
	{
		
		$req="update Materiel set desc_mat='".$_POST['desc']."' where ref_mat='".$ref."'";
		
		$db->DB_query($req);
	}
	/*                                      Modification du prix d'une liste 										   */
	if($_GET['p']=="modif_prix")
	{
		$dif=$_GET['prix']- $_POST['pr'];
		$req="select * from Compose where ref_mat=".$ref;
		$db->DB_query($req);
		
		while($ligne=$db->DB_object())
		{
			$req1="select forfait from Liste_niveau where id_nivliste=".$ligne->id_nivliste;
			$db1->DB_query($req1);
			$ligne1=$db1->DB_object();
			$for=$ligne1->forfait;
			$cha=$ligne->qte_scat*$dif;
			
			$for=$for - $cha;
			$req1="update Liste_niveau set forfait='".$for."' where id_nivliste=".$ligne->id_nivliste;
			
			$db1->DB_query($req1);
		}
			
		$req1="update Materiel set prix_mat='".$_POST['pr']."' where ref_mat='".$ref."'";
		
		$db1->DB_query($req1);
		
	}
	if($_GET['p']=="delete")
	{
	
	$req="select * from Compose where ref_mat=".$ref;
	$db->DB_query($req);
	while($ligne=$db->DB_object())
		{
			$req1="select forfait from Liste_niveau where id_nivliste=".$ligne->id_nivliste;
			$db1->DB_query($req1);
			$ligne1=$db1->DB_object();
			$for=$ligne1->forfait;
			$for=$for - ($_GET['prix'] * $ligne->qte_scat);
			$req1="update Liste_niveau set forfait='".$for."' where id_nivliste=".$ligne->id_nivliste;
			
			$db1->DB_query($req1);
			$req="delete from Compose where ref_mat='".$ref."'";
	
			
		}
		$db->DB_query($req);
	
			$req="delete from Materiel where ref_mat='".$ref."'";
			$db->DB_query($req);
	}

	$url="../gestion_liste/gestion_listes.php";
	
	?>
<?php 
header("Refresh:0;url=$url");	
?>