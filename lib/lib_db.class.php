<?php

class MySQL
{
// ---- Partie privée : les propriétés
private $connexion, $nomBase;
// Constructeur de la classe
function MySQL ($login, $motDePasse, $base, $serveur)
{
// On conserve le nom de la base
$this->nomBase = $base;
// Connexion au serveur MySQL
if (!$this->connexion = @mysql_pconnect ($serveur, $login, $motDePasse))
throw new Exception ("Erreur de connexion au serveur.");
// Connexion à la base
if (!@mysql_select_db ($this->nomBase, $this->connexion))
throw new Exception ("Erreur de connexion à la base.");
}

// ---- Partie publique -------------------------
// Méthode d'exécution d'une requête

public function execRequete ($requete)
{
$resultat = @mysql_query ($requete, $this->connexion);
if (!$resultat)
throw new Exception
("Problème dans l'exécution de la requête : $requete. "
. mysql_error($this->connexion));
return $resultat;
}
// Accès à la ligne suivante, sous forme d'objet
public function objetSuivant ($resultat)
{ return mysql_fetch_object ($resultat); }
// Accès à la ligne suivante, sous forme de tableau associatif
public function ligneSuivante ($resultat)
{ return mysql_fetch_assoc ($resultat); }

?>