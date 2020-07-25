<?php
$User = new User($conn, $_SESSION['userEmail']);
$groupId = Group::userIsOnGroup($conn, $User->getUserEmail());
?>
<script src="/asset/js/isotope.min.js"></script>
<section id="selector">
    <?php
        if(empty($groupId[0]) && empty($groupId[1])){
    ?>
    <div class="floating-logo">
        <div class="logo-app" onclick="window.location.reload();">
            <img src="/asset/icons/icon-512x512_m.png" alt="App icon">
        </div>
    </div>
    <div class="floating-text">
        <div>
            <h1>Bem-vindo(a)!</h1>
            <p>Teste</p>
        </div>
        
        <a class="waves-effect waves-light button insideout rounded">Vamos começar</a>
    </div>
<?php 
        }
?>
<header class="noselect">
        <div class="header__wrapper">
            <div class="left">
                <div class="logo-app rounded">
                    <img src="/asset/icons/icon-512x512_m.png" alt="App icon">
                </div>
            </div>
            <div class="right">
                <div class="logged-user clickable waves-effect waves-purple" data-popup-card="true" data-dy-view="user_selector">
                    <div class="user"><span>Olá, &nbsp;<b><?php echo trim(explode(' ', $User->getUserName())[0]) ?></b></span></div>
                    <div class="profile-pic"><img class="circle" src="<?PHP echo $User->getUserProfilePicture() ?>" alt=""></div>
                </div>
            </div>
        </div>

    </header>
    </header>
    <div class="selector__body">
        <div class="selector_options_wrapper">
        <?php
            
            if(!empty($groupId[0])){
                foreach($groupId[0] as $group){
                    $Group = new Group($conn, $group);
                    echo("<div data-group-id='".$Group->getGroupId()."' class=\"option circle\"><i class=\"icon fa-house-user\"></i><span>".$Group->getGroupName()."</span></div>");
                    unset($Group);
                }
            }elseif(!empty($groupId[1])){
                foreach($groupId[1] as $group){
                    $Group = new Group($conn, $group);
                    echo("<div data-group-id='".$Group->getGroupId()."' class=\"option circle\"><i class=\"icon fa-house-user\"></i><span>".$Group->getGroupName()."</span></div>");
                    unset($Group);
                }
            }
            ?>
            <div class="option circle" data-option-action='add_group'><i class="icon fa-plus"></i><span>Adicionar grupo</span></div>
            <div class="option circle" data-option-action='enter_group'><i class="icon fa-sign-in-alt"></i><span>Tenho convite</span></div>
        </div>
    </div>
</section>
<script>
$(document).ready(() => {
<?php
if(empty($groupId[0]) && empty($groupId[1])){
?>
    $('.floating-logo').animate({
        "opacity": "1",
    }, 1000, ()=>{
        $('.floating-text').animate({
        "opacity": "1",
    }, 1200);
    });

    $('.floating-text a').on('click', ()=>{
        $('.floating-text').animate({
        "opacity": "0",
        }, 500, ()=>{
            $('.selector__body').animate({
        "opacity": "1",
        }, 300, ()=>{
            $('.floating-text').hide();
        });
        });
        $('.floating-logo').animate({
        "top": "0",
        "left": "0",
        "width": "70px",
        "height": "70px",
    }, 1000, ()=>{
        $('.left .logo-app').show(0,()=>{$('.floating-logo').hide();});        
    });
    })
<?php }else{ ?>
    $('.left .logo-app').show();
    $('.selector__body').animate({
        "opacity": "1",
        }, 300);
<?php } ?>
});
</script>