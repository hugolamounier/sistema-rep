<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistemas de Gerenciamento de Republica</title>
    <meta name="description" content="Sistema de Gerenciamento de Fazendas">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff" />
    <meta name="msapplication-TileColor" content="#ffffff ">
    
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSS theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/asset/css/theme.css">

    <!-- Libs JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/5c2c380e3d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>$.widget.bridge('uitooltip', $.ui.tooltip);</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="/asset/js/jquery.mask.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
</head>

<body>
    
    <!-- Header -->
    <header class="noselect">
        <div class="header__wrapper">
            <div class="left">
                <div class="menu-collapse rounded-50">
                    <i class="material-icons">menu</i>
                </div>
            </div>
            <div class="right">
                <div class="logged-user clickable" data-popup-card="true" data-dy-view="user_info">
                    <div class="user" ><span>Olá, &nbsp;<b>Hugo</b></span></div>
                    <div class="profile-pic"><img class="circle" src="/images/profile/hugo.jpg" alt=""></div>
                </div>
                <div class="header__badges">
                    <div class="badge-item rounded-50" data-popup-card="true" data-dy-view="notifications"><div class="highlight-badge"></div><i class="material-icons">notifications</i></div>
                    <div class="badge-item rounded-50" data-popup-card="true" data-dy-view="chat"><div class="highlight-badge"></div><i class="material-icons">chat</i></div>
                </div>
            </div>
        </div>

    </header>

    <!-- Navegation -->
    <nav id="desktop" class="z-depth-2 noselect">
        <div class="logo-app rounded">
            <span>ic</span>
        </div>
        <ul>
            <li class="no-hover"><div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div></li>
        </ul>
        <ul class="nav__groups">
            <li data-menu-name="República" class="active"><i class="icon fa-home"></i></li>
            <li><i class="icon fa-home"></i></li>
        </ul>

        <ul class="collapisible-menu">
            <li class="group"><span>Teste</span></li>
            <li><div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></li>
            <li>
                <div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></div>
                <ul>
                    <li><div>Teste</div></li>
                    <li><div>Teste 2</div></li>
                </ul>
            </li>
            <li><div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></li>
        </ul>
    </nav>
    
    <nav id="mobile" class="z-depth-2 noselect">
    <div class="logo-app rounded">
            <span>ic</span>
        </div>
        <ul>
            <li class="no-hover"><div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div></li>
        </ul>

        <ul class="collapisible-menu">
            <li class="group"><span>Teste</span></li>
            <li><div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></li>
            <li>
                <div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></div>
                <ul>
                    <li><div>Teste</div></li>
                    <li><div>Teste 2</div></li>
                </ul>
            </li>
            <li><div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></li>
        </ul>
    </nav>
    
    <main>
        <section class="page">
            <div class="header">
                <div class="header__title">
                    <span>Nome da Página</span>
                    <div class="breadcrumbs">
                        <a href=""><i class="icon fa-home"></i></a>
                        <span class="breadcrumbs-separator"></span>
                        <a >Teste</a>
                        <span class="breadcrumbs-separator"></span>
                        <a >Teste</a>
                    </div>
                </div>
                <div class="header__toolbar">
                    <div class="header__btn rounded-sm tooltipped" data-position="bottom" data-tooltip="Teste"><i class="icon fa-home"></i></div>
                    <div class="header__btn rounded-sm"><i class="icon fa-home"></i></div>
                    <div class="header__btn rounded-sm"><span>Adicionar algo</span></div>
                </div>
            </div>
        </section>
    </main>

    <div class="popup-card z-depth-3 rounded-bottom-sm">
    </div>
</body>
<script src="/asset/js/theme.js" crossorigin="anonymous"></script>
<script>
$('.collapisible-menu ul').hide();
$('.collapisible-menu').hide();
$(document).ready(function(){
    $("*[data-popup-card=true]").popUpCard();
    $("nav").menu();
    $("nav#mobile").hide();
    $('.tooltipped').tooltip();
});
</script>
</html>