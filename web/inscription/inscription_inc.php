<?php 


if(isset($_POST["sinscrire"]))
{

  formulaire_inscription();

}else
{

    /*
			        verifier si l un des champs est vide 
			 */
    $bol=true;
	
	if(empty($_POST["nom"])){ $bol=false;}
	if(empty($_POST["email"])){ $bol=false;}
    if(empty($_POST["tel"])){ $bol=false;}
	if(empty($_POST["mdp"])){ $bol=false;}
	if(empty($_POST["cmdp"])){ $bol=false;}
	if(empty($_POST["nbrenfant"])){ $bol=false;}
	
	if(!$bol){
	         /*
			      si l un des chaps est vide 
				  on affiche un message 
				  et le formulaire avec sont etat precedent
			 */
	
	formulaire_inscription("Veuillez remplire tous les champs",$_POST["nom"],$_POST["email"],$_POST["tel"],$_POST["mdp"],"",$_POST["nbrenfant"]);
			}else{
			
	
									if($_POST["mdp"]!==$_POST["cmdp"]){
									
									/*
									         verifier si les mots de passe correspondent
											 sinon reaffichage du formulaire avec son etat precedent
											 et un message 
									
									*/
									
									formulaire_inscription("Mot de passe incorrecte",$_POST["nom"],$_POST["email"],$_POST["tel"],$_POST["mdp"],"",$_POST["nbrenfant"]);
																		}
																		
																		else{
									                                                /*
																					   toute les conditions sont verfiées 
																					   on inseert dans la base 
																					
																					*/
									
									                                                /*
																							Purification des variable
																					*/
																				$_POST["nom"]=htmlEntities($_POST["nom"]);
																				$_POST["email"]=htmlEntities($_POST["email"]);
																				$_POST["tel"]=htmlEntities($_POST["tel"]);
																				$_POST["tel"]=htmlEntities($_POST["mdp"]);
																				$_POST["nbrenfant"]=htmlEntities($_POST["nbrenfant"]);
																				
																				
																				 /*
			 
																					connexion a la base via la class MySQL
																				 */
																				 require_once("lib_db.class.php");
																				 
																				 $bd = new DB_connection();
																				 
																				 
																				  /*
																					 perparation de la requete 
																				 */
																				 $requete="insert into Parent values(".$_POST['nom'].",".$_POST['email'].",".$_POST['tel'].",".$_POST['mdp'].",".$_POST['nbrenfant'].")";  

																																							 
																				/*
																					execution de la requete 
																				*/
																					 $bd->execRequete($requete);
																						
																				 
																				 
																			}
	
	
				}
	
	
	
}




?>