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
    case 'add-user':
       if(!isset($_POST['userEmail']) || !isset($_POST['userName']) || !isset($_POST['userPassword'])){
            $responseObj->status = false;
            $responseObj->message = "Todos os campos são obrigatórios.";
            die(json_encode($responseObj));
       }

        $User = new User($conn, $_POST['userEmail']);
        if(is_null($User->getUserPassword()) && is_null($User->getUserName())){
            $User->setUserName($_POST['userName']);
            $User->setUserPassword($_POST['userPassword']);
            $add_user = $User->addUser(AUTH_HASH);

            if($add_user === true){
                $responseObj->status = true;
                $responseObj->message = "<i class='icon fa-smile-beam'></i> Tudo certo, agora só precisa confirmar seu e-mail.";
            }else if($add_user === 2){
                $responseObj->status = false;
                $responseObj->message = "O e-mail informado já está cadastrado.";
            }else if($add_user === false){
                $responseObj->status = false;
                $responseObj->message = "<i class='icon fa-frown'></i> Estamos com problemas, tente novamente mais tarde.";
            }
        }else{
            $responseObj->status = false;
            $responseObj->message = "O e-mail informado já está cadastrado.";
        }

        echo(json_encode($responseObj));
        return;
    break;
}

?>