<LINK REL=StyleSheet HREF="contacte.css" TYPE="text/css" MEDIA=screen>


<?php 

include("formulaire_contacter.php");

 if(!isset($_POST["ok"]))
						{
									    formulaire_contacter("teste","sdq","sdsd");
					    }
        else{
		
		
		     /*
			        verifier si l un des champs est vide 
			 */
		       $bool=true;
		       if(empty($_POST["email"])){ $bool=false;}
			   if(empty($_POST["objet"])){ $bool=false;}
			   if(empty($_POST["message"])){ $bool=false;}
		    
		     if($bool){
			 
			 /*
			    si les champs sont remplit on ecrit dans la base
			 */
			 
			 /*
			 
			    connexion a la base via la class MySQL
			 */
			 require_once("lib_db.class.php");
			 
			 $bd = new MySQL("ROOT","","test","127.0.0.1");
			 
			 /*
			     Purification des variable
			 */
			 $_POST["message"]=htmlSpecialChars($_POST["message"]);
			 $_POST["objet"]=htmlSpecialChars($_POST["objet"]);
			 $_POST["email"]=htmlSpecialChars($_POST["email"]);
			 
			 /*
			     perparation de la requete 
			 */
			 $requet="insert into message values(".$_POST["email"].",".$_POST["objet"].",".$_POST["message"].",n)";
			 
			 /*
			    execution de la requete 
			 */
			 $bd.execRequete($requet);
			 
			 /* 
			 
			 reaffichage du formulaire vide 
			
			 */
			 echo "<p>Votre message a ete bien transmis</p>";
			 formulaire_contacter("","","");
			 
			 }
			 else{
			 
			 /*
			      si l un des chaps est vide 
				  on affiche un message 
				  et le formulaire avec sont etat precedent
			 */
			 
			 echo "<p>Vous devez remplire tous les champs</p>";
			 formulaire_contacter($_POST["email"],$_POST["objet"],$_POST["message"]);
			 }
			 
			 
			 
			 
		
		}  

?>