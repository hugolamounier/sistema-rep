<section class="page">
    <div class="header">
        <div class="header__title">
            <!-- Título -->
            <div class="title"><div class="back_history circle hide-on-large-only"><i class="icon fa-arrow-left"></i></div> <span>Nome da Página</span></div>
            <!-- Caminho Página -->
            <div class="breadcrumbs hide-on-med-and-down">
                <a href=""><i class="icon fa-home"></i></a>
                <span class="breadcrumbs-separator"></span>
                <a >Teste</a>
                <span class="breadcrumbs-separator"></span>
                <a >Teste</a>
            </div>
        </div>
        <!-- Métodos Página -->
        <div class="header__toolbar">
            <div class="header__btn rounded-sm tooltipped" data-position="bottom" data-tooltip="Teste"><i class="icon fa-home"></i></div>
            <div class="header__btn rounded-sm"><i class="icon fa-home"></i></div>
            <div class="header__btn rounded-sm"><span>Adicionar algo</span></div>
        </div>
    </div>

    <section class="page__content">

    </section>



</section>
<script>
    let header_toolbar = $(".header__toolbar");
    if($.trim(header_toolbar.html()).length == 0)
    {
        header_toolbar.hide();
    }
</script>