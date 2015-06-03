<?php

session_start();
require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');
require_once(INC.'/droits.inc.php');

?>

<?php

if(isset($_GET['id']))
{
	$db = new DB_connection();
	$id = $db->quote($_GET['id']);

	$query = 'SELECT id_message, objet, message, jma, lu FROM Message WHERE utilisateur = 0 AND id_parent = '.$_SESSION['id_parent'].' AND id_message = "'.$id.'"';
	$db->DB_query($query);
	if($db->DB_count() > 0)
	{
		$req = 'DELETE from Message where id_message = "'.$id.'"';
		$db->DB_query($req);
	}
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