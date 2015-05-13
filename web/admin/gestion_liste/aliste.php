<?php

require_once('../inc/header.inc.php');
require_once('../inc/data.inc.php');
//require_once('dragndrop.php');

?>

<script type="text/javascript">

function OnDragStart(target, evt)
{
	evt.dataTransfer.setData('IdElement', target.id);
}

function OnDropTarget(target, evt)
{
	evt.preventDefault();
	var id = evt.dataTransfer.getData('IdElement');
	target.appendChild(document.getElementById(id));
	//alert(target.appendChild(document.getElementById(id)).id);
	var idMat = target.appendChild(document.getElementById(id)).id;
	
	alert(idMat);
	
	$.ajax({
                    type: "POST",
                    url: "./aliste.php",
                    data: { var : idMat },
                    success: function(data)
                    {
                        //alert(idMat);
                    }
                });

	//$.post('dragndrop.php', {variable: idMat});
	//document.location.href = "../messagerie/messagerie.php";
	
	//if(isset($_POST['var']))
//{
    //$uid = $_POST['var'];
    //echo '<script type="text/javascript">var btn = document.createElement("BUTTON");var t = document.createTextNode("CLICK ME");btn.appendChild(t);document.body.appendChild(btn);';
//}
	//array_push($tabElem,$_GET['var']);
}

</script>

		<?php //require_once('../nav.php')?>
		<div id="page">
			<table width="900" align="center"class="entete">
				<tr>
					<td><div align="right">Ajouter Une Nouvelle Liste</div></td>
				</tr>
			</table>
		<br/><br/><br/><br/>

		<div align="center" id="content">

		<?php $i = $_GET['p'];?>

<form method="post" action="ajouter_liste2.php?p=<?php echo $i; ?>" name="f1">

<?php

$db = new DB_connection();

$req = "select distinct(categorie) from Sous_categorie order by categorie";
$db->DB_query($req);
$gen = $db->DB_count();

$cpt=1;

if($i > $gen)
{
	header("Refresh:0;url=gestion_listes.php");
}

while($ligne=$db->DB_object() and $cpt <= $i)
{
	$cat = $ligne->categorie;
	$cpt++;
}

$db1 = new DB_connection();
$req1 = "select * from Materiel where id_scat in (select id_scat from Sous_categorie where categorie = '".$cat."')";
$db1->DB_query($req1);
	  
if($i==1)
{
		$requete = "select * from Niveau where code not in (select distinct(niveau) from Liste_niveau)";
		$db2 = new DB_connection();
		$db2->DB_query($requete);
		if($ligne2=$db2->DB_object())
		{
			echo '<div id="steps">';
			echo '<fieldset align="center" class="gen">';
			echo '<legend>Niveau</legend>';
			echo "Choisir le niveau  <select name=niveau>";
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
					<fieldset class="wrap" ondragover="return false" ondrop="OnDropTarget(this,event)">
						<legend>'.$cat.'</legend>';

						$cpta=0;					
						while($ligne1=$db1->DB_object())
								{
								
									echo '<div class="drag1" id="'.$ligne1->id_mat.'" draggable="true" ondragstart="OnDragStart(this,event)" disabled data-value="'.$ligne1->ref_mat.'"><input type="text" readonly="true"  value="'.$ligne1->ref_mat.'-'.$ligne1->desc_mat.'" class="in" name="'.$cpta.'"></div>';
						
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
						<div class="div1" ondragover="return false" ondrop="OnDropTarget(this,event)" id="art'.$j.'"></div>
						<div class="div2" id="pan'.$j.'"></div>
						</div>';
						
						$j++;
						$cpta--;
						}
						echo '</fieldset></div></fieldset>';
						}?>	
					
<?php					

echo'
					
					<a href="#" onclick="document.f1.submit()">Valider</a>
					</div>
				
			
			</form>';

		?>


<?php 
	require_once('../inc/footer.inc.php');
?>
	 



   		