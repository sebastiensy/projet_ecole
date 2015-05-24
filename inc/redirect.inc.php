<?php

if(!empty($_POST))
{
    $_SESSION['sauvegarde'] = $_POST;

    $page = $_SERVER['PHP_SELF'] ;
    if(!empty($_SERVER['QUERY_STRING']))
    {
        $page .= '?' . $_SERVER['QUERY_STRING'] ;
    }

    header('Location: ' . $page);
    exit;
}

if(isset($_SESSION['sauvegarde']))
{
    $_POST = $_SESSION['sauvegarde'] ;
    unset($_SESSION['sauvegarde']);
}

?>