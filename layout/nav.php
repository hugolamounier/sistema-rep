<?php
$Group = new Group($conn, $_COOKIE[SELECTOR_COOKIE]);
?>
<div class="logo-app rounded">
    <img src="/asset/icons/logo_white.png" alt="App icon">
</div>
<ul>
    <li class="no-hover"><div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div></li>
</ul>
<ul class="nav__groups">
    <li data-menu-name="Resumo"><i class="icon fa-chart-pie"></i></li>
    <li data-menu-name="Grupo"><i class="icon fa-home"></i></li>
</ul>

<ul class="collapisible-menu">
    <li href='/' data-group-name='Resumo'><div class="menu-op"><i class="icon fa-chart-pie"></i> <div>Resumo</div></li>

    <li class="group"><i class="icon fa-home"></i><span><?php echo $Group->getGroupName() ?></span></li>
        <li href='/membros' data-group-name='Grupo'><div class="menu-op"><i class="icon fa-users"></i> <div>Membros</div></li>
    
    
    
    <!-- <li>
        <div class="menu-op"><i class="icon fa-address-book"></i> <div>Teste</div></div>
        <ul>
            <li><div>Teste</div></li>
            <li><div>Teste 2</div></li>
        </ul>
    </li> -->
</ul>