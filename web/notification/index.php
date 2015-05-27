<?php

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
		echo "<span style=\"color:red\"><p><strong>Veuillez vous connecter pour consulter votre messagerie.</strong></p></span>";
	}

	?>

	<?php

	if(isset($_SESSION["id_parent"]))
	{
		$db = new DB_connection();
		$req = 'SELECT id_message, objet, message, jma, lu FROM Message WHERE utilisateur = 0 AND id_parent = '.$_SESSION['id_parent'].' ORDER BY id_message DESC';
		$db->DB_query($req);

		if($db->DB_count() > 0)
		{
			?>
			<div class="liste">
			<table width="600" align="center">
				<tr>
					<td width="90"><div align="center">N° message</div></td>
					<td width="90"><div align="center">Objet</div></td>
					<td width="90"><div align="center">Date</div></td>
					<td width="90"><div align="center">Etat</div></td>
					<td width="40"><div align="center">Opérations</div></td>
				</tr>
			<?php
			$cpt = $db->DB_count();
			while($msg = $db->DB_object())
			{
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
					echo "<td><div align='center'><a class=\"fancycmd\" href=\"../suivi/commande.php?com=".$idCom."&nom=".$_SESSION["nom_parent"]."\">".$msg->objet."</a></div></td>";
				}
				else
				{
					echo "<td><div align='center'>".$msg->objet."</div></td>";
				}
				echo "<td><div align='center'>".date("d-m-Y", strtotime($msg->jma))."</div></td>";
				echo "<td><div id=lu".$msg->id_message." align='center'>".$var."</div></td>";
				echo '<td><div align="center"><a onClick=actualiserLecture('.$msg->id_message.') class="fancy3" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'"><img title="Visualiser" src="../../img/visu.png"></a>';
				?> <a href="suppr_message.php?id=<?php echo $msg->id_message;?>"><img title="Supprimer" src="../../img/del.png"> </a></div></td>
				<?php 
				echo "<input type=\"hidden\" value=".$msg->id_message." id=".$msg->id_message.">";
				echo "</tr>";
			}
			echo "</table></div>";
		}
		else
		{
			echo "<p>Vous n'avez aucune notification.</p>";
		}
	}

	?>

	</div>
	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>