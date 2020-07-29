<?php 
require "../config.php";
$User = new User($conn, $_SESSION['userEmail']);
$Group = new Group($conn, $_COOKIE[SELECTOR_COOKIE]);


if($Group->getGroupOwner() === $User->getUserEmail()){
    $member_type = 'Administrador';
}else{
    $member_type = 'Membro';
}

?>
<div class="popup-card__header">
    <div class="popup-card__highlight">
            <div class="left">
                <img class="circle z-depth-1" src="<?php echo $User->getUserProfilePicture() ?>" width="60" alt="">
            </div>
            <div class="right">
                <div>Olimpo</div>
                <div><?php echo $member_type ?></div>
            </div>
        </div>
    </div>
</div>
<div class="popup-card__body noselect">
    <ul>
        <li><i class="icon fa-user-circle"></i><span>Perfil</span></li>
        <li><i class="icon fa-cog"></i><span>Configurações</span></li>
    </ul>
</div>

<div class="popup-card__footer">
    <a data-button-name="selector" class="waves-effect waves-light btn-small"><i class="icon fa-exchange-alt left"></i>  Trocar</a>
    <a data-button-name="logout" class="waves-effect waves-light btn-small"><i class="icon fa-sign-out-alt left"></i>  Sair</a>
</div>