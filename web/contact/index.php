<?php

require_once('../../inc/data.inc.php');
require_once(LIB.'/lib_form_contacter.php');

?>

<body id="back">

	<div id="banner">
	</div>

	<div class="menu">
		<div id="menu">
			<div id="menu1">
				<a href="../"><img src="../../img/menu/acceuil.png"></a>
				<a href="../fournitures/"><img src="../../img/menu/article.png"></a>
				<a href="../inscription/"><img src="../../img/menu/inscription.png"></a>
				<a href="../contact/"><img src="../../img/menu/contact.png"></a>
				</div>
			</div>
	</div>
	
	<div class="corps">
	<div id="page">

	<?php

		if(!isset($_POST["ok"]))
		{
			formulaire_contacter("email", "objet", "message");
		}
		else
		{
			/*
			verifier si l un des champs est vide 
			*/
			$bool=true;
			if(empty($_POST["email"])){ $bool=false;}
			if(empty($_POST["objet"])){ $bool=false;}
			if(empty($_POST["message"])){ $bool=false;}

			if($bool)
			{
				/*
				si les champs sont remplit on ecrit dans la base
				*/

				/*
				connexion a la base via la class MySQL
				*/
				$db = new DB_connection();

				/*
				Purification des variables
				*/
				$_POST["message"]=htmlSpecialChars($_POST["message"]);
				$_POST["objet"]=htmlSpecialChars($_POST["objet"]);
				$_POST["email"]=htmlSpecialChars($_POST["email"]);

				/*
				perparation de la requete 
				*/
				$requete='insert into Message (email_parent, objet, message,jma, lu) values("'.$_POST["email"].'", "'.$_POST["objet"].'", "'.$_POST["message"].'",'.getdate().', 0)';

				/*
				execution de la requete 
				*/
				$db->DB_query($requete);
				$db->DB_done();

				/* 
				reaffichage du formulaire vide 
				*/
				echo "<p>Votre message a bien été transmis.</p>";
				formulaire_contacter("", "", "");
			}
			else
			{
				/*
				si l un des chaps est vide 
				on affiche un message 
				et le formulaire avec sont etat precedent
				*/

				echo "<p>Vous devez remplir tous les champs.</p>";
				formulaire_contacter($_POST["email"],$_POST["objet"],$_POST["message"]);
			}
		}

	?>

	</div>
	</div>

<?php

require_once(INC.'/footer.inc.php');
	
?>