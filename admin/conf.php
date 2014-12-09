<?php

$connexion=mysql_connect("localhost","root","");

if (!$connexion)
{
echo "Désolé, connexion au serveur $pServeur impossible\n";
exit;
}



if (!mysql_select_db ("projet_ecole", $connexion))
{
echo "Désolé, accès à la base $pBase impossible\n";
echo "<B>Message de MySQL :</B> " . mysql_error($connexion);
exit;
}



?>