<?php
	require_once('../inc.php');
	$i=0;
	$id=0;
	$p=$_GET['p'];
	if($_GET['p']==1)
	{
	$niv=$_POST['niveau'];
	$req="insert into liste_niveau (`id_nivliste`, `niveau`, `forfait`) VALUES (NULL,'".$niv."', '0')";
	$db = new DB_connection();
	$db->DB_query($req);
	$id=$db->DB_id();
	
	}
	else
	{
		$id=$_POST['id'];
	}
	while($i<$_POST['num'])
	{
		$pos=stripos( $_POST[$i],'-');
		//echo $pos;
		$ref=substr($_POST[$i],0,$pos);
		//echo $ref;
		if(isset($_POST[$ref]))
		{
			$req="insert into compose (`id_nivliste`, `ref_mat`, `qte_scat`) VALUES (".$id.",'".$ref."', '".$_POST[$ref]."')";
			$db = new DB_connection();
			$db->DB_query($req);
			$req="select prix_mat from materiel where ref_mat='".$ref."'";
			$db = new DB_connection();
			$db->DB_query($req);
			
			$ligne=$db->DB_object();
			$prix=$ligne->prix_mat;
			
			
			$req1="select forfait from liste_niveau where id_nivliste='".$id."'";
			$db1 = new DB_connection();
			$db1->DB_query($req1);
			$ligne1=$db1->DB_object();
			
			$forfait=$ligne1->forfait;
			$forfait+=($_POST[$ref]*$prix);
			
			$req2="update liste_niveau set forfait ='".$forfait."' where id_nivliste=".$id;
			$db2 = new DB_connection();
			$db2->DB_query($req2);
			
		}
		$i++;
	}
	$p++;
	$url="ajouter_liste.php?p=".$p."&id=".$id;
	header("Location:$url");
	?>
	