<?php

function message($email, $objet, $message, $utilisateur, $id_parent, $lu=0)
{
	$db = new DB_connection();
	$query = 'INSERT INTO Message (email_parent, objet, message, jma, lu, utilisateur, id_parent) VALUES("'.$email.'", "'.$objet.'", "'.$message.'", NOW(), "'.$lu.'", "'.$utilisateur.'", "'.$id_parent.'")';
	$db->DB_query($query);
	$db->DB_done();
}

?>