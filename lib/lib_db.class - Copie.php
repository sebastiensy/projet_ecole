<?php

/**
 *
 * DB_connexion
 * Cette classe sert à gérer les connexions à la DB
 * 
 * @usage :
 * @require_once(LIB.'/lib_db.class.php');
 *
 *
 */

class DB_connection
{
	private $_connection;
	private $_result;
	private $_row;
	private $_hostname;
	private $_username;
	private $_password;
	private $_database;
	
	/**
	 * constructeur de la connexion
	 * DB_connexion::DB_connexion()
	 *
	 * @return void
	 */
	public function DB_connection()
	{
		$this->_hostname = HOST;
		$this->_username = USER;
		$this->_password = PASS;
		$this->_database = DB;
		
		if(!$this->_connection = @mysqli_connect($this->_hostname, $this->_username, $this->_password, $this->_database))
			throw new Exception ("Erreur de connexion à la base. ".mysql_error());
	}

	/**
	 * Lance la requête
	 * DB_connection::DB_query()
	 *
	 * @param $requete - chaine contenant la requete SQL à exécuter
	 * @return void
	 */
	public function DB_query($requete)
	{
		if(!$this->_result = @mysqli_query($this->_connection, $requete))
			throw new Exception ("Problème dans l'exécution de la requête : $requete. ".mysql_error($this->_connection));
		return $this->_result;
	}

	/**
	 * remonte la ligne suivante dans le resultat, sous forme d'objet
	 * DB_connection::DB_object()
	 *
	 * @return object
	 */
	public function DB_object()
	{
		$this->_row = @mysqli_fetch_object($this->_result);
	}

	/**
	 * remonte la ligne suivante dans le resultat, sous forme de tableau associatif
	 * DB_connection::DB_assoc
	 *
	 * @return array
	 */
	public function DB_object()
	{
		$this->_row = @mysqli_fetch_assoc($this->_result);
	}

	/**
	 * remonte le nombre de lignes dans la reponse
	 * DB_connection::DB_count()
	 * @return integer
	 */
	public function DB_count()
	{
		$this->_row = @mysqli_num_rows(this->_result);
		return $this->_row;
	}

	/**
	 * nettoyage de la mémoire et déconnexion de la DB
	 * DB_connection::DB_done()
	 *
	 * @return void
	 */
	 public function DB_done()
	 {
		@mysqli_free_result($this->_result);
		@mysqli_close($this->connection);
	 }
}

?>