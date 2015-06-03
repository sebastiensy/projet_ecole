<?php

//require_once('/fpdf17/fpdf.php');

?>

<?php

class PDFFournisseur extends FPDF
{
	// En-tête
	public function Header()
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
	public function Footer()
	{
	    // Positionnement à 1,5 cm du bas
	    $this->SetY(-15);
	    // Police Arial italique 8
	    $this->SetFont('Arial','I',8);
	    // Numéro de page
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	public function ImprovedTableMat($header, $data)
	{
		$this->SetFillColor(254,243,219);
	    // Largeurs des colonnes
	    $w = array(30,110, 20, 30);
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
	        //$this->Cell($w[0],6,$row[0],'LR',0,'C');
	        $this->Cell($w[0],6,$row[1],'LR',0,'C');
	        $this->Cell($w[1],6,$row[2],'LR',0,'C');
	        $this->Cell($w[2],6,$row[4],'LR',0,'C');
	        $this->Cell($w[3],6,number_format($row[3], 2, ',', ' ') ." ".EURO,'LR',0,'C');
	        $this->Ln();
	    }
	    // Trait de terminaison
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(2);
	}
}
?>