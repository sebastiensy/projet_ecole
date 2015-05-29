<?php

session_start();
require_once('../../../data/config.php');
require_once('../../../lib/lib_db.class.php');
require_once('../../../lib/lib_pdffournisseur.class.php');
require_once('../../../inc/droits.inc.php');

?>

<?php

$pdf = new PDFFournisseur();

define('EURO', chr(128));

$pdf->AliasNbPages();

$pdf->AddPage();

$db = new DB_connection();

/*
 * requete pour liste
 */
$requete1 = 'SELECT SUM(cp.qte_scat*i.exemplaire) as qte , mat.desc_mat, mat.prix_mat, mat.id_mat
	FROM Compose as cp, Materiel as mat, Inclus as i, Commande as com
    WHERE mat.id_mat = cp.id_mat AND cp.id_nivliste = i.id_nivliste AND i.id_commande = com.id_commande
    AND com.etat = 2
    GROUP BY mat.id_mat';


/*
 * requete pour les fournitures seules
 */
$requete2 = 'SELECT SUM(c.quantite) as qte, m.desc_mat, m.prix_mat, m.id_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND com.id_commande = c.id_commande 
	AND com.etat = 2
    GROUP BY c.id_mat';

$tab = array();

$db->DB_query($requete1);

$prix = array();

while($elem = $db->DB_object())
{
	if(isset($tab[$elem->id_mat]))
		$tab[$elem->id_mat] += $elem->qte;
	else
		$tab[$elem->id_mat] = $elem->qte;	
}

$db->DB_query($requete2);

while($elem = $db->DB_object())
{
	if(isset($tab[$elem->id_mat]))
		$tab[$elem->id_mat] += $elem->qte;
	else
		$tab[$elem->id_mat] = $elem->qte;	
}

$ids = array_keys($tab);

ksort($tab);

$prix = array();

if(!empty($ids))
{
	$requete3 = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
	$db->DB_query($requete3);

	if($db->DB_count() > 0)
	{
		$data = $db->DB_all();
		$cpt = 0;

		$db->DB_query($requete3);
		while($liste = $db->DB_object())
		{
			$data[$cpt++][4] = $tab[$liste->id_mat];
			array_push($prix, $tab[$liste->id_mat] * $liste->prix_mat);
		}
		$pdf->SetFont('Arial','',12);
		$header = array('Reference', 'Materiel', 'Quantite', 'Prix unitaire');
		$pdf->Ln(5);
		$pdf->ImprovedTableMat($header,$data);

			
		$somme = array_sum($prix);

		// Affiche le prix total
		$pdf->Ln(30);
		$pdf->Cell(120);
		$pdf->SetFillColor(254,243,219);
		$pdf->SetFont('Arial', 'BIU', 15);
		$pdf->Cell(70,10,'Prix Total : '.$somme.' '.EURO,1,0,'C',true);	

	}
}

$pdf->Output('Commande_fournisseur.pdf','I');


?>
