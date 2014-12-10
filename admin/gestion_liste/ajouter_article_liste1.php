<?php
	require_once('../../inc/data.inc.php');
	$id=$_POST['id'];
	$ref=$_POST['ref'];
	$qte=$_POST['qte'];
	$db = new DB_connection();
	
	if($ref!="" and $qte!="")
	{
		$req="insert into compose values('".$qte."','".$ref."','".$id."')";
		$db->DB_query($req);
	}
	$url="modif_liste.php?id=".$id;
	
 ?>

<script type="text/javascript">
	window.parent.jQuery.fancybox.close();
</script>
<?php 
header("Refresh:0;url=$url");	
?>
