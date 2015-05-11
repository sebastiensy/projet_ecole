<?php

/*
 * vérifie si l'email est disponible
 *
 */
function emailLibre($email, $db)
{
	$requete = 'Select id_parent from Parent where email_parent = "'.$email.'"';
	$db->DB_query($requete);
	if($db->DB_count() > 0)
		return false;
	return true;
}

/*
 * vérifie si le login n'est pas trop long
 *
 */
function verifLogin($login, $taille=40)
{
	return strlen($login) <= $taille;
}

/*
 * vérifie si le mot de passe est assez long
 *
 */
function verifMdp($mdp)
{
	return strlen($mdp) >= 6 && strlen($mdp) <= 16;
}

/*
 * vérifie si l'email est valide
 *
 */
function verifEmail($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/*
 * vérifie si le numéro de téléphone est valide
 *
 */
function verifTel($tel)
{
	$motif ='`^0[1-8][0-9]{8}$`';
	if(!preg_match($motif, $tel))
		return false;
	else
		return true;
}

?>