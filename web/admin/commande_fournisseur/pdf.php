<?php
require('../../../lib/fpdf17/fpdf.php');

class PDF extends FPDF
{
	// En-tête
	function Header()
	{
	    // Logo
	    $this->Image('../../../img/logo.png',10,6,70);
	    // Police Arial gras 15
	    $this->SetFont('Arial','B',15);
	    // Décalage à droite
	    $this->Cell(100);
	    // Titre
	    $this->Cell(90,10,'Commande fournisseur',1,0,'C');
	    // Saut de ligne
	    $this->Ln(20);
	}

	// Pied de page
	function Footer()
	{
	    // Positionnement à 1,5 cm du bas
	    $this->SetY(-15);
	    // Police Arial italique 8
	    $this->SetFont('Arial','I',8);
	    // Numéro de page
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	// Chargement des données
	function LoadData($file)
	{
	    // Lecture des lignes du fichier
	    $lines = file($file);
	    $data = array();
	    foreach($lines as $line)
	        $data[] = explode(';',trim($line));
	    return $data;
	}

	// Tableau amélioré
	function ImprovedTable($header, $data)
	{
	    // Largeurs des colonnes
	    $w = array(25,125, 20, 20);
	    // En-tête
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C');
	    $this->Ln();
	    // Données
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'C');
	        $this->Cell($w[1],6,$row[1],'LR',0,'C');
	        $this->Cell($w[2],6,$row[2],'LR',0,'C');
	        $this->Cell($w[3],6,$row[3] ." ".EURO,'LR',0,'C');
	        $this->Ln();
	    }
	    // Trait de terminaison
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(2);
	}

}


if (isset($_GET['pt']))
{
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);

	define('EURO', chr(128));


	// Titres des colonnes
	$header = array('Reference', 'Materiel', 'Quantite', 'Prix');

	// Chargement des données du fichier
	$data = $pdf->LoadData('cmdF.txt');
	$pdf->SetFont('Arial','',12);
	$pdf->ImprovedTable($header,$data);

	// Affiche le prix total
	$pdf->Cell(190,10,'Prix Total : '.$_GET['pt']." ".EURO,0,0,'R',false);

	$pdf->Output();
}

?>
