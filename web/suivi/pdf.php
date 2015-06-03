<?php

session_start();
require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');
require_once(LIB.'/fpdf17/fpdf.php');
require_once(LIB.'/lib_pdfparent.class.php');
require_once(INC.'/droits.inc.php');

?>

<?php
if (isset($_GET['id']))
{
	$pdf = new PDFParent();

	define('EURO', chr(128));

	$pdf->AliasNbPages();

	$pdf->AddPage();

	$db = new DB_connection();

	/*
	*	pour afficher les infos sur le parent et commande
	*/
	$requete = 'SELECT p.nom_parent, p.email_parent, p.tel_parent, c.date_cmd
				FROM Parent as p, Commande as c
				WHERE p.id_parent = c.id_parent
				AND c.id_commande = \''.$db->quote($_GET['id']).'\' AND c.id_parent = '.$_SESSION['id_parent'];

	$db->DB_query($requete);

	$dataInfo = array();


	$pdf->SetFont('Arial','',12);

	$headerInfo = array('Nom :', 'Email :', 'Tel :', 'Date de la commande :');

	if ($db->DB_count() > 0)
	{
		$pdf->Ln(10);
		$db->DB_query($requete);
		$cpt = 0;
		while ($d = $db->DB_object())
		{
			$tmp = explode('-', $d->date_cmd);
			$date = $tmp[2].'/'.$tmp[1].'/'.$tmp[0];
			$dataInfo[$cpt++] = array($d->nom_parent, $d->email_parent, $d->tel_parent, $date);
		}
		
		$pdf->TableInfo($headerInfo,$dataInfo);
	}

	$pdf->Ln(25);

	$dataListe = array();
	$prix = array();

	/*
	 * pour afficher les listes
	 */
	$requete1 = 'SELECT n.libelle, i.exemplaire, ln.forfait
	FROM Commande as com, Inclus as i, Liste_niveau as ln, Niveau as n 
	WHERE com.id_commande = i.id_commande AND i.id_nivliste = ln.id_nivliste AND ln.niveau = n.code 
	AND com.etat >= 1 AND i.id_commande = \''.$db->quote($_GET['id']).'\' AND com.id_parent = '.$_SESSION['id_parent'];

	$headerListe = array('Liste', 'Quantite', 'Forfait');

	$db->DB_query($requete1);

	$pdf->SetFont('Arial','',12);


	if ($db->DB_count() > 0)
	{
		$pdf->SetFont('Arial', 'BU', 14);
		$pdf->Cell(40,10,'Liste :');
		$pdf->Ln(10);
		$cpt = 0;
		while($liste = $db->DB_object())
		{
			$dataListe[$cpt++] = array($liste->libelle, $liste->exemplaire, $liste->forfait);
			array_push($prix,$liste->forfait * $liste->exemplaire);
		}
		$db->DB_query($requete1);
		$pdf->ImprovedTableListe($headerListe,$dataListe);

		/*
		*	pour afficher le prix total des listes
		*/
		$pdf->Ln(1);
		$somme = array_sum($prix);

		$pdf->Cell(120);
		$pdf->SetFillColor(254,243,219);
		$pdf->SetFont('Arial', 'BI', 12);
		$pdf->Cell(50,10,'Total Listes : '.number_format($somme, 2, ',', ' ').' '.EURO,1,0,'C',true);	

	}

	
	/*
	 * pour afficher les founitures seules
	 */
	$requete2 = 'SELECT m.ref_mat, m.desc_mat, c.quantite, m.prix_mat  
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND c.id_commande = com.id_commande 
	AND com.etat >= 1 AND c.id_commande = \''.$db->quote($_GET['id']).'\' AND com.id_parent = '.$_SESSION['id_parent'];

	$headerMat = array('Reference', 'Materiel', 'Quantite', 'Prix unitaire');

	$db->DB_query($requete2);

	$pdf->Ln(20);

	$dataMat = array();
	$prixMat = array();


	if ($db->DB_count() > 0)
	{
		$pdf->SetFont('Arial', 'BU', 14);
		$pdf->Cell(40,10,'Materiel :');
		$pdf->Ln(10);
		$cpt = 0;
		while($mat = $db->DB_object())
		{
			$dataMat[$cpt++] = array($mat->ref_mat, $mat->desc_mat, $mat->quantite, $mat->prix_mat);
			array_push($prix,$mat->prix_mat * $mat->quantite);
			array_push($prixMat,$mat->prix_mat * $mat->quantite);
		}
		$db->DB_query($requete2);
		$pdf->ImprovedTableMat($headerMat,$dataMat);

		/*
		*	pour afficher le prix total des materiels
		*/
		$pdf->Ln(1);
		$somme = array_sum($prixMat);

		$pdf->Cell(140);
		$pdf->SetFillColor(254,243,219);
		$pdf->SetFont('Arial', 'BI', 12);
		$pdf->Cell(50,10,'Total Materiels : '.number_format($somme, 2, ',', ' ').' '.EURO,1,0,'C',true);	
	}

	/*
	*	pour afficher le prix total
	*/
	$pdf->Ln(30);
	$somme = array_sum($prix);

	$pdf->Cell(100);
	$pdf->SetFillColor(254,243,219);
	$pdf->SetFont('Arial', 'BIU', 15);
	$pdf->Cell(70,10,'Prix Total : '.number_format($somme, 2, ',', ' ').' '.EURO,1,0,'C',true);	

	$pdf->Output($_SESSION['nom_parent']."-Commande_n".htmlentities($_GET['id'], ENT_QUOTES).".pdf","I");
}
?>