<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');

?>

<?php

$id=$_GET['id'];
$db = new DB_connection();

$req="DELETE from Message where id_message='".$id."'";

$db->DB_query($req);
	
$url="index.php";
header("Refresh:0;url=$url");

?>