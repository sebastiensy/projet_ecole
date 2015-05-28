<?php

require('../../../lib/fpdf17/fpdf.php');
require_once('../inc/data.inc.php');

?>

<?php
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

function fichier() 
{
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
	
	$db = new DB_connection();
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


	/*
	*	ouverture du fichier
	*/
	$fichierCmdF = fopen('cmdF.txt', 'w+');


	if(!empty($ids))
	{
		$requete3 = 'SELECT id_mat, ref_mat, desc_mat, prix_mat FROM Materiel WHERE id_mat IN ('.implode(',',$ids).')';
		$db->DB_query($requete3);

		if($db->DB_count() > 0)
		{
			while($liste = $db->DB_object())
			{
				/*
				*	ecriture dans le fichier
				*/
				fputs($fichierCmdF, $liste->ref_mat.';');
				fputs($fichierCmdF, $liste->desc_mat.';');
				fputs($fichierCmdF, $tab[$liste->id_mat].';');
				fputs($fichierCmdF, number_format($liste->prix_mat, 2, ',', ' ').';');
				fputs($fichierCmdF, "\r\n");
			}
		
			$somme = array_sum($prix);

			/*
			*	fermeture du fichier
			*/
			fclose($fichierCmdF);
		}
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

	// Ecrit dans le fichier
	fichier();

	// Chargement des données du fichier
	$data = $pdf->LoadData('cmdF.txt');
	$pdf->SetFont('Arial','',12);
	$pdf->ImprovedTable($header,$data);

	// Affiche le prix total
	$pdf->Cell(190,10,'Prix Total : '.$_GET['pt']." ".EURO,0,0,'R',false);

	$pdf->Output();
}

?>
