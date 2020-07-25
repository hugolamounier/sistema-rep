<?php
require "../config.php";

if(!Helper::isLogged($conn, AUTH_HASH)){
    die(Helper::returnError("Você precisa estar logado."));
}
$User = new User($conn, $_SESSION['userEmail']);
?>
<div class="popup-card__header">
    <div class="popup-card__highlight">
            <div class="left">
                <img class="circle z-depth-1" src="<?PHP echo $User->getUserProfilePicture() ?>" width="60" alt="">
            </div>
            <div class="right">
                <div><?php echo $User->getUserName() ?></div>
                <div><?php echo $User->getUserEmail() ?></div>
            </div>
        </div>
    </div>
</div>
<div class="popup-card__body noselect">
</div>

<div class="popup-card__footer">
    <a data-button-name="logout" class="waves-effect waves-light btn-small"><i class="icon fa-sign-out-alt left"></i>  Sair</a>
</div>