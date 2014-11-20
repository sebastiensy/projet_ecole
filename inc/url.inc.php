<?php

function recuperer_url()
{
    $url=explode('/', $_SERVER['REQUEST_URI']); 
	return $url;
}

?>