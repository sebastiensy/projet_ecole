<?php

require_once('../../inc/data.inc.php');

?>

<body id="back">

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

		<div id="messagerie">
			<a href="../messagerie/"><img src="../../img/menu/messagerie.png"></a>
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
	<div id="page">

	<p class="titre">Messagerie</p>
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
		$req = 'SELECT id_message, objet, message, jma FROM Message WHERE utilisateur = 0 AND id_parent = '.$_SESSION['id_parent'].' ORDER BY id_message ASC';
		$db->DB_query($req);

	
		if ($db->DB_count()>=1)
		{
			?>
			<table width="600" align="center" class="data">
				<tr>
					<th width="90" ><div align="center">N° message</div></th>
					<th width="90" ><div align="center">Objet</div></th>
					<th width="90" ><div align="center">Date</div></th>
					<th width="40" ><div align="center"></div></th>
					<th width="40" ><div align="center"></div></th>
				</tr>
			<?php 
			while($msg = $db->DB_object())
			{
				
					echo "<tr><td><div align='center'>".$msg->id_message."</div></td>";
					echo "<td><div align='center'>".$msg->objet."</div></td>";
					echo "<td><div align='center'>".$msg->jma."</div></td>";
					echo '<td><div align="center"><a class="fancy2" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'">Afficher</a></div></td>';
					?> <td><div align="center"><a href="suppr_message.php?id=<?php echo $msg->id_message;?>"><img src="../../img/del.png"> </a></div></td>

					<?php 
					echo "</tr>";
			}
			echo "</table>";

		}
		else
		{
			echo "<strong>Vous n'avez aucune notification .</strong>";
		}
	}
	
	
	?>

	</div>
	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>