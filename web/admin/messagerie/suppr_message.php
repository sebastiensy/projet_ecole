<?php

session_start();
require_once('../inc/data.inc.php');
require_once('../inc/droits.inc.php');

?>

<?php

if(isset($_GET['id']))
{
	$db = new DB_connection();

	$id = $db->quote($_GET['id']);

	$req = 'DELETE from Message where id_message = "'.$id.'"';

	$db->DB_query($req);

	$db->DB_done();
}
	
$url = "messagerie.php";
header("Refresh:0;url=$url");

?>