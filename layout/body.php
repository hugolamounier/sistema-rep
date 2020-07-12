<!-- Header -->
<header class="noselect">
        <div class="header__wrapper">
            <div class="left">
                <div class="menu-collapse rounded-50">
                    <i class="material-icons">menu</i>
                </div>
            </div>
            <div class="right">
                <div class="logged-user clickable waves-effect waves-purple" data-popup-card="true" data-dy-view="user_info">
                    <div class="user hide-on-small-only"><span>Olá, &nbsp;<b>Hugo</b></span></div>
                    <div class="profile-pic"><img class="circle" src="/images/profile/hugo.jpg" alt=""></div>
                </div>
                <div class="header__badges">
                    <div class="badge-item rounded-50 waves-effect waves-purple" data-popup-card="true" data-dy-view="notifications"><div class="highlight-badge"></div><i class="material-icons">notifications</i></div>
                    <div class="badge-item rounded-50 waves-effect waves-purple" data-popup-card="true" data-dy-view="chat"><div class="highlight-badge"></div><i class="material-icons">chat</i></div>
                </div>
            </div>
        </div>

    </header>

    <!-- Navegation -->
    <nav id="desktop" class="z-depth-2 noselect">
        <?php require("layout/nav.php") ?>
    </nav>
    
    <nav id="mobile" class="z-depth-2 noselect">
        <?php require("layout/nav.php") ?>
    </nav>
    
    <main>
        <?php
            Route::run(ROOT_DIR);
        ?>
    </main>

    <div class="popup-card z-depth-3 rounded-bottom-sm">
    </div>
