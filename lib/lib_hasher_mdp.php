<?php

function hasher_mdp($string)
{
	$magicword = '1HEj7VYSu0';
	$magicword2 = '0tsA2UvFfG';
	return sha1($magicword.$string.$magicword2);
}

?>