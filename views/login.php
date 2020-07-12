<section id="login">
    <div class="login_wrapper">
        <div class="logo-app rounded noselect" onclick="location.href='/'">
            <img src="/asset/icons/icon-512x512_m.png" alt="App icon">
        </div>
        <div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div>
        <div class="login-area">
            <h1>Entrar</h1>
            <form id="loginForm">
            <p>Para continuar, entre com suas credenciais</p>
                <div class="input-form rounded z-depth-1" data-input-name="userEmail">
                    <div>
                        <div class="input-flag"></div>
                        <input type="email" name="userEmail" id="userEmail" placeholder="usuario@exemplo.com">
                        <div class="input-icon"><i class="icon fa-at"></i></div>
                    </div>
                    <label for="userEmail">E-mail</label>
                </div>

                <div class="input-form rounded z-depth-1" data-input-name="userPassword">
                    <div>
                        <div class="input-flag"></div>
                        <input type="password" name="userPassword" id="userPassword" placeholder="Senha">
                        <div class="input-icon"><i class="icon fa-key"></i></div>
                    </div>
                    <label for="userPassword">Senha</label>
                </div>
                <a href="">Esqueceu a senha?</a>
            </form>
            <div class="login-options">
                <a class="waves-effect waves-light button insideout rounded" href="/cadastro">Cadastrar</a>
                <a data-action="login" class="waves-effect waves-light insideout button rounded">Entrar</a>
            </div>
        </div>
    </div>
</section>
<script>
$(document).on("click", "a[data-action=login]", function(){
    if($(this).data("action") == "login")
    {
        $("a[data-action=login]").addClass("simulateHover");
        auth($(this), $("#loginForm"));
    }
})
$(document).on("keypress", function(e){
    if(e.which == 13)
    {
        document.activeElement.blur();
        $("a[data-action=login]").addClass("simulateHover");
        auth($("a[data-action=login]"), $("#loginForm"));
    }
});
$(document).on("click", "a", function(){
    if($(this).hasClass("noHover"))
    {
        $(this).removeClass("noHover");
    }
})
</script>