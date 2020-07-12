<?php
require __DIR__."/config.php";

// Classes
require ROOT_DIR."/class//Helper.class.php";

// Database Connection
$conn = Helper::mysqlConnect(DATABASE_SERVER, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME, NULL, NULL, ROOT_DIR."/BaltimoreCyberTrustRoot.crt.pem");

$responseObj = new stdClass();
$responseObj->status = null;
$responseObj->message = null;
sleep(1);

if(!isset($_POST["userEmail"]) || !isset($_POST["userPassword"]))
{
    $responseObj->status = false;
    $responseObj->message = "Os campos e-mail e senha são obrigatórios.";

    die(json_encode($responseObj));
}

$userEmail = $_POST["userEmail"];
$userPassword = $_POST["userPassword"];

if(Helper::login($conn, $userEmail, $userPassword, AUTH_HASH))
{
    $responseObj->status = true;
    $responseObj->message = null;

    echo json_encode($responseObj);
}else{
    $responseObj->status = false;
    $responseObj->message = "Verifique suas credenciais e tente novamente.";

    echo json_encode($responseObj);
}
?>