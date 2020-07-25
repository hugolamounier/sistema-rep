<?php
    require 'config.php';
    
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="pt-BR"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistemas de Gerenciamento de Republica</title>
    <meta name="description" content="Sistema de Gerenciamento de Repúblicas">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#242939" />
    <meta name="apple-mobile-web-app-status-bar" content="#242939">
    <meta name="msapplication-TileColor" content="#242939 ">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <!-- Splash Screen iOS -->
    <link rel="apple-touch-startup-image" href="/images/splash/launch-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="/images/splash/launch-750x1294.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="/images/splash/launch-1242x2148.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="/images/splash/launch-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="/images/splash/launch-1536x2048.png" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="/images/splash/launch-1668x2224.png" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="/images/splash/launch-2048x2732.png" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">

    <link rel="apple-touch-icon" href="/asset/icons/icon-512x512.png">
    <link rel="icon" type="image/png" href="/asset/icons/icon-512x512_m.png" />
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSS theme -->
    <link rel="stylesheet" href="/asset/css/materialize.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/asset/css/theme.css">
    <link rel="manifest" href="/manifest.json">
    <!-- Libs JS -->
    <script src="/asset/js/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/5c2c380e3d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>$.widget.bridge('uitooltip', $.ui.tooltip);</script>
    <script src="/asset/js/materialize.min.js"></script>
    
    <script src="/asset/js/jquery.mask.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
</head>

<body>
<div class="error_handler"></div>
<div class="error_message z-depth-2"></div>
</div>
    <?php
        if (isset($_GET["logout"]))
        {
            Helper::logout();
        }

        if(Helper::isLogged($conn, AUTH_HASH))
        {
            if(!isset($_COOKIE[SELECTOR_COOKIE])){
                require (ROOT_DIR."/layout//selector.php");
            }else{
                if(!Group::existGroup($conn, $_COOKIE[SELECTOR_COOKIE])){
                    setcookie(SELECTOR_COOKIE, null, -1);
                    require (ROOT_DIR."/layout//selector.php");
                }else{
                    require (ROOT_DIR."/routing.php");
                    require (ROOT_DIR."/layout//body.php");
                }
            }
            
        }else{
            Route::add("/", "/views/login.php");
            Route::add("", "/views/login.php");
            Route::add("/cadastro", "/views/cadastro.php");
            Route::run(ROOT_DIR);
        }
    ?>
    <div class="popup-card z-depth-3">
    </div>
</body>
<script src="/asset/js/theme.js" crossorigin="anonymous"></script>
<script src="/asset/js/app-behavior.js" crossorigin="anonymous"></script>
<!-- <script>
// Check that service workers are supported
if ('serviceWorker' in navigator) {
  // Use the window load event to keep the page load performant
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js');
  });
}
</script> -->
</html>