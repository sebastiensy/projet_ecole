<?php
	require_once('../inc/header.inc.php');
	require_once('../inc/data.inc.php');
?>

<!--<html>
<head>
<title>Interface Admininistrateur:Messagerie</title>
<link rel="stylesheet" type="text/css" href="../../../css/style_page.css" /> 
<link rel="stylesheet" type="text/css" href="../../../css/style1.css" /> 
<style type="text/css">
			body{
				background-image:none;
				}
			
			
</style>
</head>
<body>
<header class="tete">
			<img src="../../../img/header.jpg" alt="header">
		<header>-->
<div id="page">
<table width="900" align="center" class="entete">
<tr>
<td ><div align="right">Messagerie</div></td>
</tr>
</table>
<br>
<br>
<table width="900" align="center" class="data">
<tr>
<th width="90" ><div align="center">N° message</div></th>
<th width="90" ><div align="center">Expediteur</div></th>
<th width="90" ><div align="center">Objet</div></th>
<th width="90" ><div align="center">Date</div></th>
<th width="90" ><div align="center">Etat</div></th>
<th width="90" ><div align="center"></div></th>
<th width="90" ><div align="center"></div></th>
</tr>


<?php 

	$db = new DB_connection();
	$req = 'SELECT * FROM Message ORDER BY id_message asc';
	$db->DB_query($req);

	while($msg = $db->DB_object())
	{
		if ($msg->lu == 0)
		{
			echo "<tr><td><div align='center'>".$msg->id_message."</div></td>";
			echo "<td><div align='center'>".$msg->email_parent."</div></td>";
			echo "<td><div align='center'>".$msg->objet."</div></td>";
			echo "<td><div align='center'>".$msg->jma."</div></td>";
			echo "<td><div align='center'>Non lu</div></td>";
			echo '<td><div align="center"><a class="fancy" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'">Afficher</a></div></td>';
			?> <td><div align="center"><a href="suppr_message.php?id=<?php echo $msg->id_message;?>"><img src="../../../img/del.png"> </a></div></td>

			<?php 
			echo "</tr>";
		}
		else
		{
			echo "<tr><td><div align='center'>".$msg->id_message."</div></td>";
			echo "<td><div align='center'>".$msg->email_parent."</div></td>";
			echo "<td><div align='center'>".$msg->objet."</div></td>";
			echo "<td><div align='center'>".$msg->jma."</div></td>";
			echo "<td><div align='center'>Lu</div></td>";
			echo '<td><div align="center"><a class="fancy" value="Afficher" href="affiche_message.php?id='.$msg->id_message.'">Afficher</a></div></td>';
			?> <td><div align="center"><a href="suppr_message.php?id=<?php echo $msg->id_message;?>"><img src="../../../img/del.png"> </a></div></td>

			<?php 
			echo "</tr>";
		}
		
	}

//<?php
//session_start();
//if(!isset($_SESSION['login']))
//{
/*
         si l admine n est pas connecté 
		 on fait une redirection
*/
//header('location:index.php?page=con_oper');
//}

//if(isset($_GET['supprimer']))
//{

/*
        suprimer un message particulier
*/
//$db = new DB_connection();
//$req1="DELETE FROM Message WHERE id_message='".$_GET['id_msg']."' ";
//$db->execRequete($req1);
//$db->DB_query($req1);  
  //unset( $_SESSION['suprimer'] );
//}
//if($_GET['afficher'])
//{

/*
        affichage du message particulier

*/
 //unset( $_SESSION['afficher'] );
//}
//else{

/*
         si ya pas de message a afficher
		 on affiche la liste de tts les messages
*/
//affichage();
//}

  //?>

<?php 
	require_once('../inc/footer.inc.php');
?>

