<?php

class panier
{
	private $_db;
	
	public function __construct($_db)
	{
		if(!isset($_SESSION['panier']))
		{
			$_SESSION['panier'] = array();
		}
	}

	public function total()
	{
		$total = 0;
		$ids = array_keys($_SESSION['panier']);
		if(empty($ids))
		{
			$products = array();
		}
		else
		{
			$product = $this->$_db->DB_query('SELECT ref_mat, prix_mat FROM Materiel WHERE id IN ('.implode(',',$ids).')');
		}
		foreach($products as $product)
		{
			$total += $product->prix_mat;
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