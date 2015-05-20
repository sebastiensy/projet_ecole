<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta charset="ISO-8859-1">
	<title>Projet &eacute;cole</title>
	<link rel="stylesheet" href="../../js/jquery-ui.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../js/fancybox/source/jquery.fancybox.css">
	<link rel="stylesheet" type="text/css" href="../../js/jquery.realperson.css">
	<link rel="stylesheet" href="../../css/progress.bar.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.plugin.js"></script>
	<script type="text/javascript" src="../../js/jquery.realperson.js"></script>
	<!-- <script src="../../js/jquery-2.1.1.min.js"></script> -->
	<script src="../../js/jquery-ui.js"></script>
	<script src="../../js/fancybox/source/jquery.fancybox.pack.js"></script>
	<script src="../../js/verifications.js"></script>
	<script>
	$(function()
	{
		var spinner = $( ".spinner" ).spinner();
		$( "#disable" ).click(function()
		{
			if ( spinner.spinner( "option", "disabled" ) )
			{
				spinner.spinner( "enable" );
			}
			else
			{
				spinner.spinner( "disable" );
			}
		});
		$( "#destroy" ).click(function()
		{
			if ( spinner.spinner( "instance" ) )
			{
				spinner.spinner( "destroy" );
			}
			else
			{
				spinner.spinner();
			}
		});
		$( "#getvalue" ).click(function()
		{
			alert( spinner.spinner( "value" ) );
		});
		$( "#setvalue" ).click(function()
		{
			spinner.spinner( "value", 5 );
		});
		$( "button" ).button();

		// Pour le suivi des commandes (admin)
		$("#fancy").fancybox({
			'width':'35%',
			'height':'50%',
			'type':'iframe',
			'autoScale':'false'
        });

		// Pour l'affichage des listes (accueil)
		$(".fancy2").fancybox({
			fitToView:false,
			autoSize:false,
			'width':'45%',
			'height':'65%',
			'autoScale': 'false',
			'type':'iframe'
		 });
	});

	$(function() {
		$("#captcha").realperson({
			chars: $.realperson.alphanumeric,
			regenerate: ''
		});
	});

	</script>
</head>
<body>