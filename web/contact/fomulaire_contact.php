<LINK href="css/formulaire_contact.css" rel="stylesheet" type="text/css">



<div id="formulaire_contact">

<h2 align="center" >CONTACTEZ-NOUS </h2>
<h1  align="center">Votre Message</h1>






<form action="" method="post">
  
    <legend><h3>Formulaire de Contact</h3></legend>
	
 
 <span ><?php if (isset($erreur_email)) echo $erreur_email;?></span></br>

<p class="pformulaire">

<label  class="contact_label" for="email_client"> votre adresse Email </label>
<input  type="text" name="email_client" value=<?PHP if(!isset($_SESSION['login'])){ echo "test";}else { echo "";} ?> />
</p>





<p class="pformulaire"><label class="contact_label" for="objet_msg">objet Message </label>
<input type="text" name="objet_msg"/>
</p> 


<p class="pformulaire">
<label class="contact_label" for="contenu_msg">Votre Message </label>
<textarea  name="contenu_msg" ></textarea> 
</p>



<p class="pformulaire">
<input type="submit" value="valider" name="submit"/>

 <input  value=" Réinitialiser " type="reset" name="Reset" />
</p> 

</form>

</div>