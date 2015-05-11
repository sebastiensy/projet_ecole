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
}

?>