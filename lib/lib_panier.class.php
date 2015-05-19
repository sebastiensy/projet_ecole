<?php

/**
 *
 * panier
 * Cette classe sert à gérer le panier
 *
 * @usage :
 * @require_once(LIB.'/lib_panier.class.php');
 * $panier = new panier(new DB_connection());
 * $panier->fonction($paramètres)
 *
 */

class panier
{
	private $_db;
	
	public function __construct($db)
	{
		if(!isset($_SESSION['panier']))
		{
			$_SESSION['panier'] = array();
			$_SESSION['liste'] = array();
		}
		$this->_db = $db;
	}

	public function recalc()
	{
		$_SESSION['panier'] = $_POST['panier']['qte'];
	}

	public function total()
	{
		$total = 0;
		$ids = array_keys($_SESSION['panier']);
		if(!empty($ids))
		{
			$this->_db->DB_query('SELECT id_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')');

			if($this->_db->DB_count() > 0)
			{
				while($mat = $this->_db->DB_object())
				{
					$total += $mat->prix_mat * $_SESSION['panier'][$mat->id_mat];
				}
			}
		}
		return $total;
	}

	public function add($product_id, $product_qte)
	{
		if(isset($_SESSION['panier'][$product_id]))
		{
			$_SESSION['panier'][$product_id] += $product_qte;
		}
		else
		{
			$_SESSION['panier'][$product_id] = $product_qte;
		}
	}

	public function del($product_id)
	{
		unset($_SESSION['panier'][$product_id]);
	}

	public function recalcList()
	{
		$_SESSION['liste'] = $_POST['liste']['qte'];
	}

	public function totalList()
	{
		$total = 0;
		$ids = array_keys($_SESSION['liste']);
		if(!empty($ids))
		{
			$this->_db->DB_query('SELECT id_nivliste, forfait FROM Liste_niveau WHERE id_nivliste IN ('.implode(',',$ids).')');

			if($this->_db->DB_count() > 0)
			{
				while($liste = $this->_db->DB_object())
				{
					$total += $liste->forfait * $_SESSION['liste'][$liste->id_nivliste];
				}
			}
		}
		return $total;
	}

	public function addList($list_id, $list_qte)
	{
		if(isset($_SESSION['liste'][$list_id]))
		{
			$_SESSION['liste'][$list_id] += $list_qte;
		}
		else
		{
			$_SESSION['liste'][$list_id] = $list_qte;
		}
	}

	public function delList($list_id)
	{
		unset($_SESSION['liste'][$list_id]);
	}

	public function delCartS()
	{
		unset($_SESSION['liste']);
		unset($_SESSION['panier']);
	}

	public function delCart()
	{
		$this->delCartS();
		$this->_db->DB_query('SELECT id_commande FROM Commande WHERE etat = 0 and id_parent = "'.$_SESSION['id_parent'].'"');
		if($this->_db->DB_count() > 0)
		{
			if($com = $this->_db->DB_object())
			{
				$this->_db->DB_query('DELETE FROM Commande WHERE id_commande = "'.$com->id_commande.'"');
				$this->_db->DB_query('DELETE FROM Inclus WHERE id_commande = "'.$com->id_commande.'"');
				$this->_db->DB_query('DELETE FROM Contient WHERE id_commande = "'.$com->id_commande.'"');
			}
		}
	}

	/*
	 * Insère le contenu du panier dans la BDD
	 * panier::saveCart($val)
	 *
	 * @param $val
	 * 0 -> sauvegarde le panier
	 * 1 -> passe la commande
	 * @return void
	 *
	 */
	public function saveCart($val)
	{
		$idsL = array();
		$idsP = array();

		if(isset($_SESSION["liste"]))
			$idsL = array_keys($_SESSION['liste']);
		if(isset($_SESSION["panier"]))
			$idsP = array_keys($_SESSION['panier']);

		$query = 'SELECT id_commande FROM Commande WHERE etat = 0 AND id_parent = "'.$_SESSION["id_parent"].'"';
		$this->_db->DB_query($query);
		if($this->_db->DB_count() > 0)
		{
			if($com = $this->_db->DB_object())
			{
				$idCom = $com->id_commande;
				$this->_db->DB_query('UPDATE Commande set etat = "'.$val.'" WHERE id_parent = "'.$_SESSION["id_parent"].'" AND id_commande = "'.$idCom.'"');
			}
		}
		else
		{
			$d = date("Y-m-d");
			$query = 'INSERT INTO Commande (date_cmd, etat, id_parent) VALUES ("'.$d.'", "'.$val.'", "'.$_SESSION["id_parent"].'")';
			$this->_db->DB_query($query);
			$idCom = $this->_db->DB_id();
		}

		if(!empty($idsL))
		{
			$this->_db->DB_query('SELECT id_nivliste FROM Liste_niveau WHERE id_nivliste IN ('.implode(',',$idsL).')');

			if($this->_db->DB_count() > 0)
			{
				$query = 'INSERT INTO Inclus (id_commande, id_nivliste, exemplaire) VALUES';
				while($liste = $this->_db->DB_object())
				{
					$query .= '("'.$idCom.'", "'.$liste->id_nivliste.'", "'.$_SESSION['liste'][$liste->id_nivliste].'"),';
				}
				$query = substr($query, 0, -1);

				$query .= ' ON DUPLICATE KEY UPDATE exemplaire=VALUES(exemplaire)';

				$this->_db->DB_query($query);
			}
		}
		if(!empty($idsP))
		{
			$this->_db->DB_query('SELECT id_mat FROM Materiel WHERE id_mat IN ('.implode(',',$idsP).')');

			if($this->_db->DB_count() > 0)
			{
				$query = 'INSERT INTO Contient (id_commande, id_mat, quantite) VALUES';
				while($mat = $this->_db->DB_object())
				{
					$query .= '("'.$idCom.'", "'.$mat->id_mat.'", "'.$_SESSION['panier'][$mat->id_mat].'"),';
				}
				$query = substr($query, 0, -1);

				$query .= ' ON DUPLICATE KEY UPDATE quantite=VALUES(quantite)';

				$this->_db->DB_query($query);
			}
		}
		if($val == 1)
			$this->delCartS();
	}

	public function loadCart()
	{
		$this->_db->DB_query('SELECT id_commande, etat, id_parent FROM Commande WHERE etat = 0 AND id_parent = "'.$_SESSION['id_parent'].'"');

		if($this->_db->DB_count() > 0)
		{
			if($com = $this->_db->DB_object())
				$idCom = $com->id_commande;
			$this->_db->DB_query('SELECT * FROM Inclus WHERE id_commande = "'.$idCom.'"');
			if($this->_db->DB_count() > 0)
			{
				while($liste = $this->_db->DB_object())
				{
					$this->addList($liste->id_nivliste, $liste->exemplaire);
				}
			}
			$this->_db->DB_query('SELECT * FROM Contient WHERE id_commande = "'.$idCom.'"');
			if($this->_db->DB_count() > 0)
			{
				while($mat = $this->_db->DB_object())
				{
					$this->add($mat->id_mat, $mat->quantite);
				}
			}
		}
	}
}

?>