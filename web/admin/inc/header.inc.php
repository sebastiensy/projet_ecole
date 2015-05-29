<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta charset="ISO-8859-1">
	<title>Interface Administrateur</title>
	<link rel="stylesheet" href="../../../js/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="../../../css/style_page.css" />
	<link rel="stylesheet" type="text/css" href="../../../css/style1.css" />
	<link rel="stylesheet" type="text/css" href="../../../css/myButton.css" />
	<!-- <link rel="stylesheet" href="../../../js/fancybox/source/jquery.fancybox-1.3.4.css" type="text/css" media="screen" /> -->
	<link rel="stylesheet" href="../../../js/fancybox/source/jquery.fancybox.css">
	<style type="text/css">
			body{
				background-image:none;
				}
	#accordion-resizer {
    	width: 1000px;
    	height: 100px;
  	}
	</style>
	<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
	<!-- <script type="text/javascript" src="../../../js/fancybox/source/jquery.fancybox-1.3.4.pack.js"></script> -->
	<script src="../../../js/fancybox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript">
	$( document ).ready(function() {
			$("#fancy").fancybox({
				fitToView:false,
				autoSize:false,
				type: "iframe",
				width: '70%',
				height: '60%',
				'autoScale': 'false'
			});
	});
	$( document ).ready(function() {
			$("a.fancyMsg").fancybox({
				fitToView:false,
				autoSize:false,
				type: "iframe",
				width: '60%',
				height: '50%',
				'autoScale': 'false'
			});
	});
	$( document ).ready(function() {
			$("#fancy1").fancybox({
				fitToView:false,
				autoSize:false,
				type: "iframe",
				width: '70%',
				height: '60%',
				'autoScale': 'false'
			});
	});
	$( document ).ready(function() {
			$("a.fancy").fancybox({
				fitToView:false,
				autoSize:false,
				type: "iframe",
				width: '70%',
				height: '60%',
				'autoScale': 'false'
			});
	});
	$(function() {
		var offset = $("#tabd").offset();
		var topPadding = 15;
		$(window).scroll(function() {
			if ($(window).scrollTop() > offset.top) {
				$("#tabd").stop().animate({
					marginTop: $(window).scrollTop() - offset.top + topPadding
				});
			} else {
				$("#tabd").stop().animate({
					marginTop: 0
				});
			};
		});
	});
	$(function() {
    	$( "#date_limite" ).datepicker({
    		dateFormat: "dd/mm/yy",
    		altField: "#date_cache",
    		altFormat : "yy-mm-dd"
    	});
  	});
	function fnOpenNormalDialog() {
		$("#dialog-confirm").html("Voulez-vous confirmer la suppression ?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "Confirmation",
			height: 180,
			width: 350,
			buttons: {
				"Oui": function () {
					$(this).dialog('close');
					callback(true);
				},
					"Non": function () {
					$(this).dialog('close');
					callback(false);
				}
			}
		});
	}
	function actualiserLecture(champ)
	{
		document.getElementById('lu'+champ).innerHTML = "Lu";
	}
	function setId(id)
	{
		document.getElementById("iden").value = id;
	}
	</script>
</head>
	<div class="tete">
		<div id="site"><a href="../../"><img src="../../../img/porte.png" title="Retour"></a></div>
		<img src="../../../img/header.jpg" alt="header">
	</div>