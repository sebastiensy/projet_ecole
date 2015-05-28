<?php

function envoiMail($dest, $sujet, $messageTxt)
{
	if(!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $dest))
	{
		$n = "\r\n";
	}
	else
	{
		$n = "\n";
	}
	$messageHtml = "<html><head></head><body>".$messageTxt."</body></html>";

	$boundary = "-----=".md5(rand());

	$header = "From: \"Rentree.Facile\" <rentree.facile@gmail.com>".$n;
	$header .= "Reply-to: \"Rentree.Facile\" <rentree.facile@gmail.com>".$n;
	$header.= "MIME-Version: 1.0".$n;
	$header.= "Content-Type: multipart/alternative;".$n." boundary=\"$boundary\"".$n;

	$message = $n . "--" . $boundary . $n;
	$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"".$n;
	$message .= "Content-Transfer-Enconding: 8bit".$n;
	$message .= $n . $messageHtml . $n;
	$message .= $n . "--" . $boundary . $n;

	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$n;
	$message.= "Content-Transfer-Encoding: 8bit".$n;
	$message.= $n.$messageHtml.$n;

	$message.= $n."--".$boundary."--".$n;
	$message.= $n."--".$boundary."--".$n;

	return mail($dest, $sujet, $message, $header);
}

?>