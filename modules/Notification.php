<?php

require "../config.php";

define("CURRENT_FILE", __FILE__);


$responseObj = new stdClass();
$responseObj->status = NULL;
$responseObj->message = NULL;

if(isset($_GET['a']))
{
    $a = $_GET['a'];
}else{
    $responseObj->status = false;
    $responseObj->message = "Acesso inválido.";
    die(json_encode($responseObj));
}
switch($a)
{
    case 'checkNotification':
        
    break;
}

?>