<?php
    require "../config.php";

    if(!Helper::isLogged($conn, AUTH_HASH)){
        die(Helper::returnError("Você precisa estar logado."));
    }
?>
<div class="selector__add">
    <div class="logo-app" onclick="window.location.reload();">
        <img src="/asset/icons/icon-512x512_m.png" alt="App icon">
    </div>
    <h1>Criar grupo, vamos lá!</h1>
    <p>Primeiro precisamos que você escolha o tipo do grupo que está criando:</p>
    <div class="type_selector_wrapper">
        <div class="option circle" data-group-type='1'><i class="icon fa-users"></i><span>República</span></div>
        <div class="option circle" data-group-type='2'><i class="icon fa-home"></i><span>Casa</span></div>
    </div>
    <div class="hidden_inputs">
        <p>Agora nos conte mais sobre o seu grupo:</p>
        <form id="addGroupForm">
        <input type="hidden" name="groupType" value="0">
        <div class="row">
            <div class="col s12">
                <div class="input-form rounded z-depth-1" data-input-name="groupName">
                    <div>
                        <div class="input-flag"></div>
                        <input type="text" name="groupName" id="groupName" placeholder="Nome do grupo">
                        <div class="input-icon"><i class="icon fa-font"></i></div>
                    </div>
                    <label for="groupName">Nome do grupo</label>
                </div>
            </div>

            <div class="col s12 m12 l9">
                <div class="input-form rounded z-depth-1" data-input-name="groupAddress">
                    <div>
                        <div class="input-flag"></div>
                        <input type="text" name="groupAddress" id="groupAddress" placeholder="Rua Exemplo, 1">
                        <div class="input-icon"><i class="icon fa-map-marker-alt"></i></div>
                    </div>
                    <label for="groupAddress">Endereço do grupo</label>
                </div>
            </div>
            <div class="col s12 m12 l3">
                <div class="input-form rounded z-depth-1" data-input-name="groupCEP">
                    <div>
                        <div class="input-flag"></div>
                        <input type="text" name="groupCEP" id="groupCEP" placeholder="CEP do grupo">
                        <div class="input-icon"><i class="icon fa-map-marked-alt"></i></div>
                    </div>
                    <label for="groupCEP">CEP do grupo</label>
                </div>
            </div>
            <div class="col s12">
                <a class="waves-effect waves-light button insideout rounded" data-button-name='add_group_submit'>Criar Grupo</a>
            </div>
        </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function(){
    $('.option').on('click', function(e){
        $(this).parent().find('div.option.active').removeClass('active');
        $(this).addClass('active');
        $('input[name=groupType]').val($(this).data('group-type'));
    });

    $('input[name=groupCEP]').mask('99999-999');
});
</script>