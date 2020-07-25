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
    case 'add-group':
        if(!isset($_POST['groupName']) || !isset($_POST['groupAddress']) || !isset($_POST['groupCEP']) || !isset($_POST['groupType'])){
            $responseObj->status = false;
            $responseObj->message = "É necessário preencher todos os campos obrigatórios.";
            die(json_encode($responseObj));
        }

        $Group = new Group($conn);
        $Group->setGroupName($_POST['groupName']);
        $Group->setGroupOwner($_SESSION['userEmail']);
        $Group->setGroupType((int) $_POST['groupType']);
        $Group->setGroupAddress($_POST['groupAddress']);
        $Group->setGroupCEP($_POST['groupCEP']);

        $check = $Group->addGroup();
        if($check){
            $responseObj->status = true;
            $responseObj->message = "<i class='icon fa-smile-beam'></i> Tudo certo, seu grupo foi criado com sucesso!.";
        }else{
            $responseObj->status = false;
            $responseObj->message = "<i class='icon fa-frown'></i> Estamos com problemas, tente novamente mais tarde.";
        }
        die(json_encode($responseObj));
    break;
}

?>