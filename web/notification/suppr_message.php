<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');

?>

<?php

if(isset($_GET['id']))
{
	$id=$_GET['id'];
	$db = new DB_connection();

	$req="DELETE from Message where id_message='".$id."'";

	$db->DB_query($req);
}

$link = $_SERVER["QUERY_STRING"];
if(!empty($link))
{
	$url = "index.php?".$link;
}
else
{	
	$url = "index.php";
}

header("Refresh:0;url=$url");

?>