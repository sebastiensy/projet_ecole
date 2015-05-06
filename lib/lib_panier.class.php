<?php

class panier
{
	private $_db;
	
	public function __construct($db)
	{
		if(!isset($_SESSION['panier']))
		{
			$_SESSION['panier'] = array();
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
}

?>