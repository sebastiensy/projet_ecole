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
	    $this->Cell(90,10,'Commande n°'.$_GET['id'],1,0,'C');
	    // Saut de ligne
	    $this->Ln(20);
	}

	public function BasicTableListe($header)
	{
		$this->SetFillColor(254,243,219); //cellule de l'entête
		$this->SetTextColor(0); //texte en noir
		$this->SetFont('Arial', '', 16); //Arial 16
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

	public function BasicTableMat($header)
	{
		$this->SetFillColor(254,243,219); //cellule de l'entête
		$this->SetTextColor(0); //texte en noir
		$this->SetFont('Arial', '', 16); //Arial 16
		// En-tête
		foreach($header as $col)
			$this->Cell(40,7,$col,1,0,'C',true); //true pour afficher la couleur
		$this->Ln(); //saut de ligne
		$this->SetFont('Arial', '', 12); //remettre en Arial 12
	}

	public function TableMat($data)
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
}
?>