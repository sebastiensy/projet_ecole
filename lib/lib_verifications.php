<?php

/*
 * v�rifie si l'email est disponible
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
 * v�rifie si le login n'est pas trop long
 *
 */
function verifLogin($login, $taille=40)
{
	return strlen($login) <= $taille;
}

/*
 * v�rifie si le mot de passe est assez long
 *
 */
function verifMdp($mdp)
{
	return strlen($mdp) >= 6 && strlen($mdp) <= 16;
}

/*
 * v�rifie si l'email est valide
 *
 */
function verifEmail($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/*
 * v�rifie si le num�ro de t�l�phone est valide
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