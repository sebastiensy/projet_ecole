<?php

require_once('/fpdf17/fpdf.php');

?>

<?php

class PDFParent extends FPDF
{
	// En-tête
	public function Header()
	{
	    // Logo
	    $this->Image('../../img/logo.png',10,6,70);
	    // Police Arial gras 15
	    $this->SetFont('Arial','B',15);
	    // Décalage à droite
	    $this->Cell(100);
	    // Titre
	    $str = utf8_decode('Commande n°');
	    $this->Cell(90,10,$str.$_GET['id'],1,0,'C');
	    // Saut de ligne
	    $this->Ln(20);
	}

	// Pied de page
	public function Footer()
	{
	    // Positionnement à 1,5 cm du bas
	    $this->SetY(-15);
	    // Police Arial italique 8
	    $this->SetFont('Arial','I',8);
	    // Numéro de page
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	public function TableInfo($header, $data)
	{
		$this->SetFillColor(254,243,219); //cellule de l'entête
		$this->SetTextColor(0); //texte en noir
		// En-tête
		$cpt=0;
		foreach($header as $col)
		{
			$this->SetFont('Arial', 'B', 12); //Arial Gras 12
			$this->Cell(50,7,$col,1,0,'C',true); //true pour afficher la couleur
			$this->SetFont('Arial', '', 12); //Arial 12
			$this->Cell(50,7,$data[0][$cpt],1,0,'C');
			$cpt++;
			$this->Ln();
		}
	}
	
	public function ImprovedTableListe($header, $data)
	{
		$this->Cell(20);
		$this->SetFillColor(254,243,219);
	    // Largeurs des colonnes
	    $w = array(50,50,50);
	    // En-tête
   		$this->SetFont('Arial', 'B', 12);
	    for($i=0;$i<count($header);$i++)
        {
        	$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
	    $this->Ln();
	    // Données
	    $this->Cell(20);
		$this->SetFont('Arial', '', 12); //Arial 12
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'C');
	        $this->Cell($w[1],6,$row[1],'LR',0,'C');
	        $this->Cell($w[2],6,number_format($row[2], 2, ',', ' ') ." ".EURO,'LR',0,'C');
	        $this->Ln();
	        $this->Cell(20);
	    }
	    // Trait de terminaison
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(2);
	}
	
	public function ImprovedTableMat($header, $data)
	{
		$this->SetFillColor(254,243,219);
	    // Largeurs des colonnes
	    $w = array(25,115, 20, 30);
	    // En-tête
   		$this->SetFont('Arial', 'B', 12);
	    for($i=0;$i<count($header);$i++)
        {
        	$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
	    $this->Ln();
	    // Données
   		$this->SetFont('Arial', '', 12); //Arial 12
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'C');
	        $this->Cell($w[1],6,$row[1],'LR',0,'C');
	        $this->Cell($w[2],6,$row[2],'LR',0,'C');
	        $this->Cell($w[3],6,number_format($row[3], 2, ',', ' ') ." ".EURO,'LR',0,'C');
	        $this->Ln();
	    }
	    // Trait de terminaison
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(2);
	}
}
?>