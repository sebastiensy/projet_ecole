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
	$motif = '/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/';
	if(!preg_match($motif, $email))
		return false;
	else
		return true;
	//return filter_var($email, FILTER_VALIDATE_EMAIL);
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

/*
 * vérifie si le nombre d'enfants est valide
 *
 */
function verifEnfant($enfant)
{
	if(is_numeric($enfant))
		return true;
	return false;
}

/*
 * vérifie si c'est bien un prix
 *
 */
function verifPrix($prix)
{
	if(is_numeric($prix))
		return true;
	return false;
}

/*
 * vérifie si le captcha est correct
 *
 */
function rpHash($value) {
    $hash = 5381;
    $value = strtoupper($value);
    for($i = 0; $i < strlen($value); $i++) {
        $hash = (leftShift32($hash, 5) + $hash) + ord(substr($value, $i));
    }
    return $hash; }

function leftShift32($number, $steps) {
    $binary = decbin($number);
    $binary = str_pad($binary, 32, "0", STR_PAD_LEFT);
    $binary = $binary.str_repeat("0", $steps);
    $binary = substr($binary, strlen($binary) - 32);
    return ($binary{0} == "0" ? bindec($binary) :
        -(pow(2, 31) - bindec(substr($binary, 1)))); 
}

?>