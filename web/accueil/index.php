<?php

session_start();
require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_listes.php');
require_once(INC.'/redirect.inc.php');

?>

<script>
function afficLink()
{
	var id = document.getElementById("selniv").value;
	document.getElementById("lienfancy").innerHTML = "<a class=fancy2 href=modliste.php?id="+id+"><img title=Visualiser src=../../img/icon_OK.png></a>";
}
</script>

<body onload="afficheWorkflow()" id="back">

	<div id="banner">
	</div>

	<div class="menu">

		<div id="connexion">
			<?php
				require_once("../connexion/login.php");
			?>
		</div>
		<div id="faq"><a href="../faq/"><img src="../../img/aide.png"></a></div>

		<div id="menu">

			<div id="menu1">
				<a href="../"><img src="../../img/menu/accueil.png"></a>
				<a href="../fournitures/"><img src="../../img/menu/article.png"></a>
				<?php 
				if(!isset($_SESSION['id_parent']))
				{
					?>
					<a href="../inscription/"><img src="../../img/menu/inscription.png"></a>
					<?php
				}
				else
				{
					?>
					<a href="../compte/"><img src="../../img/menu/compte.png"></a>
					<?php 
				}
				?>
				<a href="../contact/"><img src="../../img/menu/contact.png"></a>
			</div>

		</div>

		<div id="notification">
			<a href="../notification/"><img src="../../img/menu/messagerie.png"></a>
		</div>

		<div id="panier">
			<a href="../panier/"><img src="../../img/menu/panier.png"></a>
		</div>

		<?php 
		if(isset($_SESSION['droits']))
		{
			if ($_SESSION['droits'] ==1 )
			{
			?>
			<div id="admin">
				<a href="../admin/"><img src="../../img/menu/admin.png"></a>
			</div>
			<?php
			}
		}
		?>

	</div>

	<div class="corps">

		<div id="workflow"></div>

		<div id="page">

			<p class="titre">Accueil</p>
			<h3><u>Listes de fournitures :</u></h3>
			<?php affichage($panier); ?>

			<?php
			if(isset($_SESSION['id_parent']))
			{
				$db = new DB_connection();
				$query = 'select ln.id_nivliste, ln.forfait, n.Libelle from Niveau n, Liste_niveau ln WHERE ln.niveau = n.code order by ln.niveau';
				$db->DB_query($query);
				if($db->DB_count() > 0)
				{
				?>
				<p><table><tr>
				<td>Retirer des articles basés sur la liste :</td>
				<td><select id="selniv" onChange="afficLink()">
					<?php
					$tab = array();
					while($liste = $db->DB_object())
					{
						echo "<option value=".$liste->id_nivliste.">".$liste->Libelle."</option>";
						array_push($tab, $liste->id_nivliste);
					}
					?>
				</select></td><?php $id = $tab[0]; ?>
				<?php
				echo "<td><div id=\"lienfancy\"><a class=\"fancy2\" href=\"modliste.php?id=".$id."\"><img title=\"Visualiser\" src=\"../../img/icon_OK.png\"></a></div></td>";
				?>
				</tr></table></p>
				<?php
				}
			}
			?>

			<br/><p><a class="btn" href="../fournitures"/>Autres fournitures</a></p>

		</div>

	</div>

<?php

require_once(INC.'/footer.inc.php');

?>