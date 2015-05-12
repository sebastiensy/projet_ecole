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
	$motif = '/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/';
	if(!preg_match($motif, $email))
		return false;
	else
		return true;
	//return filter_var($email, FILTER_VALIDATE_EMAIL);
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

/*
 * v�rifie si le nombre d'enfants est valide
 *
 */
function verifEnfant($enfant)
{
	if(is_int($enfant) && $enfant <= 10 && $enfant > 0)
		return true;
	return false;
}

?>