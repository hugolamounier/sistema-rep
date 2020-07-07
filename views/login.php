<section id="login">
    <div class="login_wrapper">
        <div class="left hide-on-med-and-down">
            <div class="login-banner blur">
                <h1>Título foda</h1>
            </div>
        </div>
        <div class="right">
            <div class="logo-app rounded">
                <span>ic</span>
            </div>
            <div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div>
            <div class="login-area">
                <form id="loginForm">
                    <div class="input-form rounded z-depth-1" data-input-name="userEmail">
                        <div>
                            <div class="input-flag"></div>
                            <input type="email" name="userEmail">
                            <div class="input-icon"><i class="icon fa-at"></i></div>
                        </div>
                        <label>E-mail</label>
                    </div>

                    <div class="input-form rounded z-depth-1" data-input-name="userPassword">
                        <div>
                            <div class="input-flag"></div>
                            <input type="password" name="userPassword">
                            <div class="input-icon"><i class="icon fa-key"></i></div>
                        </div>
                        <label>Senha</label>
                    </div>
                </form>
                <a href="">Esqueceu a senha?</a>
                <div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div>
                <div class="break"></div>
                <div class="login-options">
                    <a data-action="login" class="waves-effect waves-light btn-large">Entrar</a>
                    <a class="waves-effect waves-light btn-large">Cadastrar</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).on("click", "a.btn-large", function(){
    if($(this).data("action") == "login")
    {
        auth($(this), $("#loginForm"));
    }
})
$(document).on("keypress", function(e){
    if(e.which == 13)
    {
        auth($("a[data-action=login]"), $("#loginForm"));
    }
});
</script>