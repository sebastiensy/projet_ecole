<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta charset="ISO-8859-1">
	<title>Interface Administrateur</title>
	<link rel="stylesheet" href="../../../js/jquery-ui.css">
	<!--<link rel="stylesheet" href="../../../js/fancybox/source/jquery.fancybox.css">-->
	<!--<link rel="stylesheet" href="../../../css/progress.bar.css">-->
	<link rel="stylesheet" type="text/css" href="../../../css/style_page.css" />
	<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />
	<link rel="stylesheet" type="text/css" href="../../../css/myButton.css" />
	<link rel="stylesheet" href="../../../js/fancybox/source/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	<style type="text/css">
			body{
				background-image:none;
				}
	#accordion-resizer {
    	width: 1000px;
    	height: 100px;
  	}
	</style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
	<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
	<!--<script type="text/javascript" src="../../../js/fancybox/source/jquery.fancybox.pack.js"></script>-->
	<script type="text/javascript" src="../../../js/fancybox/source/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="../../../js/ajax.js"></script>
	<script type="text/javascript">
	$( document ).ready(function() {
			$("#fancy").fancybox({
				
				type: "iframe",
				width: '70%',
				height: '60%',
				onClosed: function() {   
				parent.location.reload(true); 
    ;}
								});
	});
	$( document ).ready(function() {
			$("#fancy1").fancybox({
				
				type: "iframe",
				width: '70%',
				height: '60%',
				onClosed: function() {   
				parent.location.reload(true);
				;}
								});
	});
	$( document ).ready(function() {
			$("a.fancy").fancybox({
				
				type: "iframe",
				width: '70%',
				height: '60%'
			});
	});

	/*function recupererQte(champ)
	{
		var qte = document.getElementById(champ).value;
		document.getElementById("B"+champ).href = "ajouter_liste.php?id="+champ+"&qte="+qte;
	}*/

	function ajouterFourniture(champ)
	{
		var id = champ;
		var qte = document.getElementById(champ).value;

		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if (xhr.readyState==4 && xhr.status==200)
			{
				response = xhr.responseText;
				document.getElementById('resultat2').innerHTML = response;
			}
		}
		xhr.open("POST", "./reponse.php?reponse=2", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id=" + id + "&qte=" + qte);
	}

	/*
		pour ajouter un article
	*/
	/*function subm()
		{
			document.getElementById('maj').submit();
		}
	function verif()
		{
			var ref=document.f1.ref.value;
			if(ref=="")
			{
				alert("Veuillez Entrer une reference");
				document.f1.ref.focus();
				return false();
			}
			var desc=document.f1.desc.value;
			if(desc=="")
			{
				alert("Veuillez Entrer une Description");
				document.f1.desc.focus();
				return false();
			}
			var prix=document.f1.desc.value;
			if(prix=="" || isNaN(prix)
			{
				alert("Veuillez Entrer un prix par unite");
				document.f1.prix.focus();
				return false();
			}
			
		}*/


	/*
		pour ajouter une liste
	*/
	/*var cpt=0;

		function allowDrop(ev) {
			ev.preventDefault();
		}

		function drag(ev) {
			ev.dataTransfer.setData("text", ev.target.id);
		}

		function drop(ev) {
			ev.preventDefault();
			var data = ev.dataTransfer.getData("text");
	
			ev.target.appendChild(document.getElementById(data));
			$(ev.target).next('.div2').append($('<input type="number" size=2 value=1 name="'+data+'"min=1>'));
			
		}
	function getValue(id)
	{
		return document.getElemetById(id);
	}*/

	function subm()
	{
		document.getElementById('maj').submit();
	}

	</script>
</head>
	<header class="tete">
		<img src="../../../img/header.jpg" alt="header">
	</header>