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

	public function delCart()
	{
		unset($_SESSION['liste']);
		unset($_SESSION['panier']);
	}

	public function orderCart()
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
			$this->_db->DB_query('UPDATE Commande set etat = 1 WHERE id_parent = "'.$_SESSION["id_parent"].'"');
			//$idCom = $this->_db->DB_object()->id_commande;
		}
		else
		{
			$d = date("Y-m-d");
			$query = 'INSERT INTO Commande (date_cmd, etat, id_parent) VALUES ("'.$d.'", 1, "'.$_SESSION["id_parent"].'")';
			$this->_db->DB_query($query);
			//$idCom = $this->_db->DB_id();
		}
		$idCom = $this->_db->DB_id();

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
				$this->_db->DB_query($query);
			}
		}
		$this->delCart();
	}

	public function getCart()
	{
		
	}
}

?>