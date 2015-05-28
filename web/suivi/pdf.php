<?php

require_once('../../data/config.php');
require_once(LIB.'/lib_db.class.php');
require_once(LIB.'/fpdf17/fpdf.php');
//require_once(LIB.'/lib_pdf.class.php');


?>



<?php

/*class PDF extends FPDF
{
	private $_db;

	public function __construct($db)
	{
		$this->_db = $db;
	}

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

	/*public function BasicTableListe($header)
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
}*/

// En-tête
	 /*function Header()
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
	}*/

	/*function BasicTableListe($header)
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

	function TableListe($data)
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

	function BasicTableMat($header)
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

	function TableMat($data)
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
	}*/

if (isset($_GET['id']))
{


	$pdf = new FPDF();
	//Connexion à la base
	 
	//$bdd = mysqli_connect('localhost','root','','projet_ecole');
	$db = new DB_connection();

	$headerListe = array('Liste', 'Quantite', 'Forfait');


	/*
	 * pour affiche les listes
	 */
	$requete1 = 'SELECT n.libelle, i.exemplaire, ln.forfait
	FROM Commande as com, Inclus as i, Liste_niveau as ln, Niveau as n 
	WHERE com.id_commande = i.id_commande AND i.id_nivliste = ln.id_nivliste AND ln.niveau = n.code 
	AND com.etat >= 1 AND i.id_commande = '.$_GET['id'];
 
	//$result  = mysqli_query($bdd, $requete1);
	$db->DB_query($requete1);

	//$data = mysqli_fetch_all($result);
	$data = $db->DB_all();

	//var_dump($data);
 
	
	$pdf->AliasNbPages();

	$pdf->AddPage();

	$pdf->SetFont('Arial','',12);


	if ($db->DB_count() > 0)
	{
		$pdf->BasicTableListe($headerListe);
		$pdf->TableListe($data);
	}

	


	/*
	 * pour afficher les founitures seules
	 */
	$requete2 = 'SELECT c.quantite, m.desc_mat, m.prix_mat, m.ref_mat 
	FROM Contient as c, Materiel as m, Commande as com 
	WHERE c.id_mat = m.id_mat AND c.id_commande = com.id_commande 
	AND com.etat >= 1 AND c.id_commande = '.$_GET['id'];

	$headerMat = array('Reference', 'Materiel', 'Quantite', 'Prix unitaire');

	//$result  = mysqli_query($bdd, $requete2);
	//$data = mysqli_fetch_all($result);

	$db->DB_query($requete2);

	//$data = mysqli_fetch_all($result);
	$data = $db->DB_all();

	$pdf->Ln();

	if ($db->DB_count() > 0)
	{
		$pdf->BasicTableMat($headerMat);
		$pdf->TableMat($data);
	}
		

	$pdf->Output();


}



?>