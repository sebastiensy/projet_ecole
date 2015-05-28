<?php

require_once('/fpdf17/fpdf.php');

?>

<?php

class PDF extends FPDF
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

	public function BasicTableListe($header)
	{
		$this->SetFillColor(254,243,219); //cellule de l'entête
		$this->SetTextColor(0); //texte en noir
		$this->SetFont('Arial', '', 12); //Arial 12
		// En-tête
		foreach($header as $col)
			$this->Cell(40,7,$col,1,0,'C',true); //true pour afficher la couleur
		$this->Ln(); //saut de ligne
		$this->SetFont('Arial', '', 12); //remettre en Arial 12
	}

	public function TableListe($data)
	{
		// Données
		foreach($data as $row) 
		{
			foreach($row as $col)
			{
				$this->Cell(40,7,$col,1,0,'C');
			}
			$this->Ln();
		}
	}

	/*public function BasicTableMat($header)
	{
		$this->SetFillColor(254,243,219); //cellule de l'entête
		$this->SetTextColor(0); //texte en noir
		$this->SetFont('Arial', '', 12); //Arial 12
		// En-tête
		foreach($header as $col)
			$this->Cell(40,7,$col,1,0,'C',true); //true pour afficher la couleur
		$this->Ln(); //saut de ligne
		$this->SetFont('Arial', '', 12); //remettre en Arial 12
	}

	public function TableMat($data)
	{
		// Largeurs des colonnes
	    $w = array(25,125, 20, 20);
		// Données
		foreach($data as $row) 
		{
			//foreach($row as $col)
			//{
				//$this->Cell(40,7,$col,1,0,'C');
				$this->Cell($w[0],6,$row[0],'LR',0,'C');
	        	$this->Cell($w[1],6,$row[1],'LR',0,'C');
	        	$this->Cell($w[2],6,$row[2],'LR',0,'C');
	        	$this->Cell($w[3],6,$row[3] ." ".EURO,'LR',0,'C');
			//}
			$this->Ln();
		}
	}*/
	function TableInfo($header, $data)
	{
		$this->SetFillColor(254,243,219); //cellule de l'entête
		$this->SetTextColor(0); //texte en noir
		$this->SetFont('Arial', '', 12); //Arial 12
		// En-tête
		$cpt=0;
		foreach($header as $col)
		{
			$this->Cell(50,7,$col,1,0,'C',true); //true pour afficher la couleur
			$this->Cell(40,7,$data[0][$cpt],1,0,'C');
			$cpt++;
			$this->Ln();
		}
	}
	function ImprovedTableListe($header, $data)
	{
		$this->Cell(20);
		$this->SetFillColor(254,243,219);
	    // Largeurs des colonnes
	    $w = array(50,50,50);
	    // En-tête
	    for($i=0;$i<count($header);$i++)
        {
        	$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
	    $this->Ln();
	    // Données
	    $this->Cell(20);
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'C');
	        $this->Cell($w[1],6,$row[1],'LR',0,'C');
	        $this->Cell($w[2],6,$row[2] ." ".EURO,'LR',0,'C');
	        $this->Ln();
	        $this->Cell(20);
	    }
	    // Trait de terminaison
	    $this->Cell(array_sum($w),0,'','T');
	    $this->Ln(2);
	}
	function ImprovedTableMat($header, $data)
	{
		$this->SetFillColor(254,243,219);
	    // Largeurs des colonnes
	    $w = array(25,120, 20, 30);
	    // En-tête
	    for($i=0;$i<count($header);$i++)
        {
        	$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
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
?>