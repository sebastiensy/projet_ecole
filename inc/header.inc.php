<!doctype html>
<html lang="en">
<head>
	<meta charset="ISO-8859-1">
	<title>Titre</title>
	<link rel="stylesheet" href="../../js/jquery-ui.css">
	<script src="../../js/jquery-2.1.1.min.js"></script>
	<script src="../../js/jquery-ui.js"></script>
	<script>
	$(function() {
	var spinner = $( ".spinner" ).spinner();
	$( "#disable" ).click(function() {
	if ( spinner.spinner( "option", "disabled" ) ) {
	spinner.spinner( "enable" );
	} else {
	spinner.spinner( "disable" );
	}
	});
	$( "#destroy" ).click(function() {
	if ( spinner.spinner( "instance" ) ) {
	spinner.spinner( "destroy" );
	} else {
	spinner.spinner();
	}
	});
	$( "#getvalue" ).click(function() {
	alert( spinner.spinner( "value" ) );
	});
	$( "#setvalue" ).click(function() {
	spinner.spinner( "value", 5 );
	});
	$( "button" ).button();
	});
	</script>
</head>