<?php
if(!isset($_SESSION['droits']))
{
	header("Location: ../../index.php");
	exit;
}
else
{
	if($_SESSION['droits'] != 1)
	{
		header("Location: ../../index.php");
		exit;
	}
}
?>