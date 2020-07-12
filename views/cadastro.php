<section id="cadastro">
    <div class="wrapper">
        <div class="logo-app rounded noselect" onclick="location.href='/'">
            <img src="/asset/icons/icon-512x512_m.png" alt="App icon">
        </div>
        <div class="menu-separetor"><div class="separetor"></div><div class="separetor"></div><div class="separetor"></div></div>
        <div class="cadastro-body">
            <h1>Junte-se a nós</h1>
            <p>Cadastre-se e comece a controlar sua vida financeira de forma dinâmica e divertida.</p>
        <form id="cadastroForm" onsubmit="return false;">
        <div class="input-form rounded z-depth-1" data-input-name="userName">
                <div>
                    <div class="input-flag"></div>
                    <input type="text" name="userName" id="userName" placeholder="Nome completo">
                    <div class="input-icon"><i class="icon fa-font"></i></div>
                </div>
                <label for="userName">Nome completo</label>
            </div>
            <div class="input-form rounded z-depth-1" data-input-name="userEmail">
                <div>
                    <div class="input-flag"></div>
                    <input type="email" name="userEmail" id="userEmail" placeholder="usuario@exemplo.com">
                    <div class="input-icon"><i class="icon fa-at"></i></div>
                </div>
                <label for="userEmail">E-mail</label>
            </div>
            <div class="two-column">
                <div class="input-form rounded z-depth-1" data-input-name="userPassword">
                    <div>
                        <div class="input-flag"></div>
                        <input type="password" name="userPassword" id="userPassword" placeholder="Senha">
                        <div class="input-icon"><i class="icon fa-key"></i></div>
                    </div>
                    <label for="userPassword">Senha</label>
                </div>
                <div class="input-form rounded z-depth-1" data-input-name="userPasswordCheck">
                    <div>
                        <div class="input-flag"></div>
                        <input type="password" name="userPasswordCheck" id="userPasswordCheck" placeholder="Confirmar">
                        <div class="input-icon"><i class="icon fa-key"></i></div>
                    </div>
                    <label for="userPasswordCheck">Confirmar Senha</label>
                </div>
            </div>
            <p>Ao se cadastrar, você concorda com nossos <a href="">Termos de Uso</a> e <a href="">Política de Dados</a>.</p>
        </form>
        <a class="waves-effect waves-light button insideout rounded">Cadastre-se</a>
        </div>
    </div>
</section>