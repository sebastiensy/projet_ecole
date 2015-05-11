<?php
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
?>

<script type="text/javascript" src="../../../js/ajout_liste.js"></script>

<!--<html>
	<head>
		<title>Interface Admin:Gestion des Listes</title>
		<link rel="stylesheet" type="text/css" href="../../../css/style1.css" /> 
		<link rel="stylesheet" type="text/css" href="../../../css/style_page.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>
		var cpt=0;

		function allowDrop(ev) {
			ev.preventDefault();
		}

		function drag(ev) {
			ev.dataTransfer.setData("text", ev.target.id);
		}

		function drop(ev) {
			ev.preventDefault();
			var data = ev.dataTransfer.getData("text");
	
			ev.target.appendChild(document.getElementById(data));
			$(ev.target).next('.div2').append($('<input type="number" size=2 value=1 name="'+data+'"min=1>'));
			
}

</script>
<script type=javascript>
function getValue(id)
{
	return document.getElemetById(id);
	}
	</script>
<style type="text/css">
		body {
			
			
			background-image:none;
			}
</style>
	</head>
	<body>
		<header class="tete">
			<img src="../../../img/header.jpg" alt="header">
		<header>-->
		<?php //require_once('../nav.php')?>
		<div id="page">
			<table width="900" align="center"class="entete">
				<tr>
					<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
				</tr>
			</table>
		<br>
		<br>
		<br>
		<br>
		<div align="center" id="content" >

			<?php $i=$_GET['p'];?>

<form method="post" action="ajouter_liste2.php?p=<?php echo $i;?>" name="f1">
<?php 
//$i=$_GET['p'];
	  $db = new DB_connection();
	  
	  $req="select distinct categorie from Sous_categorie order by categorie asc";
	  $db->DB_query($req);
	  $gen=$db->DB_num_rows();
	  
	  $cpt=1;
	   if($i>$gen)
	  {
		header("Refresh:0;url=gestion_listes.php");
	  }
	  while($ligne=$db->DB_object() and $cpt<=$i){
	  
	  $cat=$ligne->categorie;
	  $cpt++;
	  }
	
	  
	  
	  $db1 = new DB_connection();
	  $req1="select * from Materiel where id_scat in (select id_scat from Sous_categorie where categorie='".$cat."')";
	  $db1->DB_query($req1);
	  
if($i==1)
{
		$requete="select * from Niveau where code not in(select distinct niveau from Liste_niveau)";
		$db2 = new DB_connection();
		$db2->DB_query($requete);
		if($ligne2=$db2->DB_object())
		{
			echo '<div id="steps">';
			echo '<fieldset align="center" class="gen">';
			echo '<legend>Niveau</legend>';
			echo 'Choisir Le Niveau  <select name=niveau>';
			echo '<option value=';
			echo $ligne2->code;
			echo '>';
			echo $ligne2->Libelle;
			echo '</option>';
			while($ligne2=$db2->DB_object())
			{
			echo '<option value=\"';
			echo $ligne2->code;
			echo '\">';
			echo $ligne2->Libelle;
			echo '</option>';
			}
			echo '</select>';
			echo '</fieldset>';
		}
		else
		{
			
			header("Location: gestion_listes.php");
			//echo "<script>alert(\"Une liste par niveau! tous les niveaux ont une liste\")</script>";
		}
		
		
}
if(isset($_GET['id']))
{
	echo'<input type=hidden name=id value=';
	echo $_GET['id'];
	echo '>';

			echo '
		
			
		
				<div id="steps">
					<fieldset align="center" class="gen">
					<legend>Choisir Les articles</legend>
					<div id="wrap">
					

					<div class="left">
					<fieldset class="wrap">
						<legend>'.$cat.'</legend>';
						
						$cpta=0;					
						while($ligne1=$db1->DB_object())
								{
								
									echo '<div class="drag1" id="'.$ligne1->ref_mat.'" ondrop="drop(event)" ondragover="allowDrop(event)" draggable="true" ondragstart="drag(event)" disabled data-value="'.$ligne1->ref_mat.'"><input type="text" readonly="true"  value="'.$ligne1->ref_mat.'-'.$ligne1->desc_mat.'" class="in" name="'.$cpta.'"></div>';
						
						$cpta++;
						}
						echo '						
					</fieldset>
					</div>
				
				<div class="right" id= "liste">
				
				<input type="hidden" name="num" value="'.$cpta.'"> 
					<fieldset class="wrap">
						<legend>Les Articles de la liste</legend>';
						
						 
						$j=3;
						while($cpta>0)
						{
						echo '
						<div class="wrap">
						<div class="div1" ondrop="drop(event)" ondragover="allowDrop(event)" id="art'.$j.'"></div>
						<div class="div2" id="pan'.$j.'"></div>
						</div>';
						
						$j++;
						$cpta--;
						}
						echo '</fieldset></div></fieldset>';
						}?>	
					
<?php					echo'
					
					<a href="#" onclick="document.f1.submit()">Valider</a>
					</div>
				
			
			</form>'
		;?>

<?php 
	require_once('../inc/footer.inc.php');
?>
	 



   		