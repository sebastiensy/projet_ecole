<?php
	require_once('../conf.php');
	$id=$_POST['id'];
	$ref=$_POST['ref'];
	$qte=$_POST['qte'];
	
	if($ref!="" and $qte!="")
	{
		$req="insert into compose values('".$id."','".$ref."','".$qte."')";
		$myql_result=mysqli_query($req,$connexion);
	}
	$url="modif_liste.php?id=".$id;
	
 ?>

<script type="text/javascript">
	window.parent.jQuery.fancybox.close();
</script>
<?php 
header("Refresh:0;url=$url");	
?>
