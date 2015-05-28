<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');
require_once(LIB.'/lib_pdf.class.php');


?>



<?php
if (isset($_GET['id']))
{
	$pdf = new PDF();

	define('EURO', chr(128));

	$pdf->AliasNbPages();

	$pdf->AddPage();

	$db = new DB_connection();

	/*
	 * pour affiche les listes
	 */
	$requete1 = 'SELECT n.libelle, i.exemplaire, ln.forfait
	FROM Commande as com, Inclus as i, Liste_niveau as ln, Niveau as n 
	WHERE com.id_commande = i.id_commande AND i.id_nivliste = ln.id_nivliste AND ln.niveau = n.code 
	AND com.etat >= 1 AND i.id_commande = '.$_GET['id'];

	$headerListe = array('Liste', 'Quantite', 'Forfait');

	$db->DB_query($requete1);

	$data = $db->DB_all();

	$pdf->SetFont('Arial','',12);


	if ($db->DB_count() > 0)
	{
		$pdf->ImprovedTableListe($headerListe,$data);
	}

	
	/*
	 * pour afficher les founitures seules
	 */
	$requete2 = 'SELECT m.ref_mat, m.desc_mat, c.quantite, m.prix_mat  
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND c.id_commande = com.id_commande 
	AND com.etat >= 1 AND c.id_commande = '.$_GET['id'];

	$headerMat = array('Reference', 'Materiel', 'Quantite', 'Prix unitaire');

	$db->DB_query($requete2);

	$data = $db->DB_all();

	$pdf->Ln(2);
	$pdf->Ln();

	if ($db->DB_count() > 0)
	{
		$pdf->ImprovedTableMat($headerMat,$data);
	}
		

	$pdf->Output();


}



?>