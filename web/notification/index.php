<?php

session_start();
require_once('../../inc/data.inc.php');

?>

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

		<div id="workflow">
		</div>

	<div id="page">

	<p class="titre">Notifications</p>
	<?php
	if(!isset($_SESSION["id_parent"]))
	{
		echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour consulter vos notifications.</strong></p></span>";
	}

	?>

	<?php

	if(isset($_SESSION["id_parent"]))
	{
		$db = new DB_connection();
		$req = 'SELECT id_message, objet, message, jma, lu FROM Message WHERE utilisateur = 0 AND id_parent = '.$_SESSION['id_parent'].' ORDER BY id_message DESC';
		$db->DB_query($req);

		//
		$nb_elems = 10; // nombre d'�l�ments par page
		$nb_pages = ceil($db->DB_count() / $nb_elems);

		if(!empty($_GET["page"]))
		{
			$page = intval(htmlentities($_GET["page"], ENT_QUOTES));
			if($_GET["page"] > $nb_pages || $_GET["page"] < 1)
				$page = 1;
		}
		else
			$page = 1;

		$debut = ($page - 1) * $nb_elems;

		$req .= ' LIMIT '.$debut.', '.$nb_elems.'';
		//

		$db->DB_query($req);

		if($db->DB_count() > 0)
		{
			?>
			<div id="notif">
			<div class="liste">
			<table class="sortable">
				<tr>
					<td id="sort">N� message</td>
					<td id="sort">Objet</td>
					<td id="sort">Date</td>
					<td id="sort">Etat</td>
					<td class="sorttable_nosort">Actions</td>
				</tr>
			<?php
			$cpt = $db->DB_count();
			while($msg = $db->DB_object())
			{
				?> <form method="POST" action=""> <?php
				$str = $msg->objet;
				$idCom = 0;
				if(@preg_match('#^([^0-9]+)([0-9]+)$#', $str, $part))
				{
					$idCom = $part[2];
				}

				$var = ($msg->lu == 0) ? 'Non lu' : 'Lu';
				echo "<tr><td><div align='center'>".$cpt--."</div></td>";
				if(strstr($msg->objet, "Commande"))
				{
					echo "<td><div align='center'><a class=\"fancycmd\" href=\"../suivi/commande.php?com=".$idCom."\">".$msg->objet."</a></div></td>";
				}
				else
				{
					echo "<td><div align='center'>".$msg->objet."</div></td>";
				}
				if(isset($_GET["page"]))
				{
					$p = $page;
				}
				else
				{
					$p = 1;
				}
				$date = new DateTime($msg->jma);
				$date = $date->format('d/m/Y');
				echo "<td><div align='center'>".$date."</div></td>";
				echo "<td><div id=lu".$msg->id_message." align='center'>".$var."</div></td>";
				echo '<td><div align="center"><a onClick=actualiserLecture('.$msg->id_message.') class="fancy3" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'"><img title="Visualiser" src="../../img/visu.png"></a>&nbsp;&nbsp;';
				?> <!-- <a href="suppr_message.php?id=<?php /*echo $msg->id_message;*/ ?>&amp;page=<?php /*echo $p;*/ ?>"><img title="Supprimer" src="../../img/del.png"></a></div></td> -->
				<?php echo "<input type=\"button\" title=\"Supprimer\" onClick=setId(".$msg->id_message.") class=\"del btnOpenDialog\"/><div id=\"dialog-confirm\"></div></td>"; ?>
				<?php 
				echo "<input type=\"hidden\" value=".$msg->id_message." id=".$msg->id_message.">";
				echo "</tr></form>";
			}
			echo "</table></div></div>";
			echo "<input type=\"hidden\" value=\"\" id=\"iden\">";
			echo "<input type=\"hidden\" value=".$p." id=\"pag\">";
		}
		else
		{
			echo "<p>Vous n'avez aucune notification.</p>";
		}
	}

	// affichage des pages
	?>
	<div id="pages">
	<?php
	if(isset($nb_pages))
	{
		if($nb_pages > 1)
		{
			for($i=1; $i <= $nb_pages; $i++)
			{
				if($i==$page)
				{
					echo "<span style=\"font-weight:bold; color:brown\">".$i."</span> | "; 
				}	
				else
				{
					echo '<a href="index.php?page='.$i.'">'.$i.'</a>';
					echo ' | ';
				}
			}
		}
	}
	?>
	</div>

	</div>
	</div>

<script>
$('.btnOpenDialog').click(fnOpenNormalDialog);
function callback(value) {
	var _id = document.getElementById("iden").value;
	var _page = document.getElementById("pag").value;
	if (value) {
		location.href = "suppr_message.php?id="+_id+"&page="+_page;
	} else {
	}
}
</script>

<?php

require_once(INC.'/footer.inc.php');
	
?>