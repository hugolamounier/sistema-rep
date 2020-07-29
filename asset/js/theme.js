var mobile_menu = false;
const primary_color = "#6a1b9a";
const label_color = "#9e9e9e";
const DEBUG = true;
old_console_log = console.log;
console.log = function() {
    if ( DEBUG ) {
        old_console_log.apply(this, arguments);
    }
}
// general functions
function getRotationDegrees(obj) {
    var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform")    ||
    obj.css("-ms-transform")     ||
    obj.css("-o-transform")      ||
    obj.css("transform");
    if(matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
    } else { var angle = 0; }
    return (angle < 0) ? angle + 360 : angle;
}

function isMobile(){
    if(window.innerWidth <= 992){
        return true;
    }else{
        return false;
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}
function isObject(str){
    if(typeof str === 'object' && str !== null){
        return true;
    }
}
function isValidJSON(str){
    try{
        JSON.parse(str);
    }catch(e){
        return false;   
    }
    return true;
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
    return emailReg.test(email);
  }


// Form input
$(".input-form div > input").focusin(function(){
    $(this).parent().parent().find("label").animate({
        color: primary_color,
    }, 50); 
});
$(".input-form div > input").focusout(function(){
    $(this).parent().parent().find("label").animate({
        color: label_color,
    }, 50); 
});

function returnInputError(element)
{
    element.find("input").addClass("error").promise().done(function(){
        element.find("div.input-flag").html("<i class=\"icon fa-exclamation-circle\"></i>");
    });
    
}
function clearInputError(element)
{
    if(element === undefined)
    {
        $("[data-input-name]").each(function(){
            var $this = $(this);
            $this.find("input").removeClass("error").promise().done(function(){
                $this.find("div.input-flag").html("");
            });
        });
    }else{
        element.find("input").removeClass("error").promise().done(function(){
            element.find("div.input-flag").html("");
        });
    }
    
}

// End Form input

// Loading
function showLoadingOnElement(element)
{
    var DOM_element = "<div class=\"loading\"><div class=\"lds-dual-ring\"></div></div>";
    element.append(DOM_element);
    element.find("div.loading").fadeIn(100);
}
function removeLoadingOnElement(element, callback)
{
    element.find("div.loading").fadeOut(100, function(){
        $(this).remove();
        typeof callback == "function" && callback();
    });
}
function displayLoadError(element, text)
{
    var DOM_element = "<div class=\"error\"><i class=\"icon fa-times-circle\"></i><span>"+text+"</span></div>";
    element.html("").promise().done(function(){
        element.append(DOM_element);
    });
}
var element_content;
function showLoadingOnButton(element, shrinkTo)
{
    if(element_content != null){ element_content = null; }
    element_content = element.html();
    element.animate({
        "flex-basis": shrinkTo,
    }, 600, function(){
        element.html("<i class=\"loading\"></i>");
        element.find("i").html("<div class=\"lds-dual-ring\"></div>");
    });
}
function closeLoadingOnButton(element, growTo)
{
    element.animate({
        "flex-basis": growTo,
    }, 600, function(){
        setTimeout(() =>{
            element.html(element_content);
            element_content = null;
            if(window.matchMedia('(hover: none)').matches === true){element.addClass("noHover");}
            if(element.hasClass("simulateHover")){ $(element).removeClass("simulateHover");}
            if(element.hasClass("waves-effect")){ $(element).removeClass("waves-effect waves-light");}
        }, 250);
    });
}
function loadingOnButton(element) // element se refere ao i
{
    $(element).removeClass().addClass("icon-loading").html("<div class=\"lds-dual-ring\"></div>");
}
function hideLoadingOnButton(element, icon)
{
    $(element).addClass("icon "+icon);
}
// end loading

// Navegation
(function( $ ){
    $.fn.menu = function() {
        $(document).on("mouseenter", "nav#desktop", $.throttle(function(){
            var $this = $(this);
            $("nav#desktop > .nav__groups").hide(0, function(){
                $this.animate({
                    width: "250",
                }, 200, function(){
                    $("nav > ul.collapisible-menu").show();
                    $this.find("li").addClass("full-menu");
                });
                
            });
        },1000));
        $(document).on("mouseleave", "nav#desktop", $.debounce(function(){
            var $this = $(this);
            $("nav#desktop > ul.collapisible-menu").hide(0, function(){
                if($this.width() > 80)
                {
                    $this.animate({
                        width: "80",
                    }, 150, function(){
                        $("nav > .nav__groups").show();
                    });
                    $(this).find("li").removeClass("full-menu");
                } 
            });
        },800));
    }; 
 })( jQuery );

$(document).on("click", "#desktop .collapisible-menu > li", function(){
    if($(this).find("ul").length > 0)
    {
        var degree = 0;
        if(getRotationDegrees($("nav#desktop ul.collapisible-menu li > div.menu-op .arrow")) == 315)
        {
            degree = 45;
        }else if(getRotationDegrees($("nav#desktop ul.collapisible-menu li > div.menu-op .arrow")) == 45){
            degree = -45;
        }
        $('nav#desktop ul.collapisible-menu li > div.menu-op .arrow').animate(
            { deg: degree },
            {
              duration: 50,
              step: function(now) {
                $(this).css({ transform: 'rotate(' + now + 'deg)' });
              }
            }
          );
        $(this).find("ul").slideToggle(200);
    }
});
$(document).on("click", "#mobile .collapisible-menu > li", function(){
    if($(this).find("ul").length > 0)
    {
        var degree = 0;
        if(getRotationDegrees($("nav#mobile ul.collapisible-menu li > div.menu-op .arrow")) == 315)
        {
            degree = 45;
        }else if(getRotationDegrees($("nav#mobile ul.collapisible-menu li > div.menu-op .arrow")) == 45){
            degree = -45;
        }
        $('nav#mobile ul.collapisible-menu li > div.menu-op .arrow').animate(
            { deg: degree },
            {
              duration: 50,
              step: function(now) {
                $(this).css({ transform: 'rotate(' + now + 'deg)' });
              }
            }
          );
        $(this).find("ul").slideToggle(200);
    }
});
$(".collapisible-menu li > ul").click(function(){
    event.stopPropagation();
});
$(function () {
    $(".collapisible-menu > li").each(function(){
        if($(this).children("ul").length > 0)
        {
            $(this).find("div.menu-op").append('<i class="arrow"></i>');
        }
    });
});
$(document).click(function(event){

    // Nav
    var nav = $("nav#mobile");
    var target = $(event.target);
    if(mobile_menu == true)
    {
        if(event.target.tagName != "NAV" && !target.parents("#mobile").length)
        {
            nav.toggle("slide", function(){
                mobile_menu = false;
            });
        }
    }

    // close popup-card
    var popupCard = $(".popup-card");
    if(popupCard.is(":visible") && !$(event.target).hasClass("popup-card") && !$(event.target).parents(".popup-card").length && event.target.tagName != "HEADER" && !$(event.target).parents("header").length)
    {
        hideEffect(".popup-card");
    }else if(popupCard.is(":visible")){   
        if(event.target.tagName == "HEADER" || $(event.target).parents("header").length)
        {
            if(!$(event.target).data("popup-card") && !$(event.target).parent().data("popup-card") && !$(event.target).parents("*[data-popup-card=true]").length)
            {
                hideEffect(".popup-card");
            }
            
        }
    }

});
$(document).on("click", ".menu-collapse", function(e){
    e.stopPropagation;
    var nav = $("nav#mobile");
    if(mobile_menu == false)
    {
        nav.toggle("slide", function(){
            mobile_menu = true;
        });
    }
    
})

    // Navegation Actions
    $('.collapisible-menu > li[href]').on('click', function(){
        window.location.href = $(this).attr('href');
    });
    
    //Navegation active item
    function setActiveNavItem(){
        let pathname = window.location.pathname; 
        pathname = pathname.split('/');

        let item_active = $('nav').find("li[href='/"+pathname[1]+"']");
        item_active.addClass('active');
        $("nav").find("li[data-menu-name='"+item_active.data('group-name')+"']").addClass('active');
    }


// End Navegation

// Login
function auth(element, form)
{
    var formData = new FormData(form[0]);
    $.ajax({
        url: "/auth.php",
        type: "POST",
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 10000,
        beforeSend: function(jqXHR, settings){
            clearInputError();
            showLoadingOnButton(element, "20%");
        },
        success: function(response){
            var data = JSON.parse(response);
            if(data.status === true)
            {
                window.location.reload();
            }else{
                error("Não foi possível autenticar, verifique os dados e tente novamente.");
                returnInputError($("*[data-input-name=userEmail]"));
                returnInputError($("*[data-input-name=userPassword]"));
            }
        },
        error: function(jqXHR, textStatus, errorThrown){

        },
        complete: function(jqXHR, textStatus){
            closeLoadingOnButton(element, "60%");
        }
    });
}
async function logout(){
    const logout = await $.ajax({
        url: '/index.php?logout=1',
        type: 'GET',
        success: function(data){
            eraseCookie('group-id');
            window.location.href='/';
        }
    });
}
async function cadastrar(element, form){
    clearInputError();
    showLoadingOnButton(element, "auto");
    let formData = new FormData(form[0]);
    if(formData.get('userName').length === 0){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=userName]"));
        error("É obrigatório o preenchimento do seu nome completo.");
        return;
    }else if(formData.get('userEmail').length === 0 || !validateEmail(formData.get('userEmail'))){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=userEmail]"));
        error("O e-mail é obrigatório e deve ser válido.");
        return;
    }else if(formData.get('userPassword').length < 8 || formData.get('userPassword').length > 32){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=userPassword]"));
        error("A senha deve ter no mínimo 8 e no máximo 32 caracteres.");
        return;
    }else if(formData.get('userPasswordCheck') != formData.get('userPassword')){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=userPasswordCheck]"));
        error("As senhas informadas não correspondem, verifique as senhas digitadas.");
        return;
    }

    $.ajax({
        url: '/modules/User.php?a=add-user',
        type: 'POST',
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 10000,
        success: (response) =>{
            if(isValidJSON(response)){
                let response_data = JSON.parse(response);
                if(response_data.status === true){
                    error(response_data.message).then(()=>{
                        window.location.href='/';
                    });
                }else if(response_data.status === false){
                    error(response_data.message);
                }
            }else{
                console.log(response);
                error('Não foi possível atender sua requisição, tente novamente.');
            }
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR+ '\n' +textStatus + '\n' +errorThrown);
        },
        complete: () =>{
            closeLoadingOnButton(element, "auto");
        }
    });
    return;
}
// End Login


// Selector

    // add_group
async function addGroup(element, form){
    clearInputError();
    showLoadingOnButton(element, "auto");
    let formData =  new FormData(form[0]);
    if(formData.get('groupType') == 0){
        closeLoadingOnButton(element, "auto");
        error("É necessário escolher o tipo do seu grupo.");
        let animationTime = 35;
        $(".type_selector_wrapper").animate({ left : '+=25px' }, animationTime).animate({ left : '-=25px' }, animationTime).animate({ left : '-=25px' }, animationTime).animate({ left : '+=25px' }, animationTime).animate({ left : '+=25px' }, animationTime).animate({ left : '-=25px' }, animationTime).animate({ left : '-=25px' }, animationTime).animate({ left : '+=25px' }, animationTime);
        return;
    }else if(formData.get('groupName').length === 0){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=groupName]"));
        error("É obrigatório o preenchimento do nome do grupo.");
        return;
    }else if(formData.get('groupAddress').length === 0){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=groupAddress]"));
        error("É obrigatório o preenchimento do endereço do grupo.");
        return;
    }else if(formData.get('groupCEP').length < 9){
        closeLoadingOnButton(element, "auto");
        returnInputError($("*[data-input-name=groupCEP]"));
        error("É obrigatório o preenchimento de um CEP válido.");
        return;
    }else{
        var ajax_validation = false;
        const result = await $.ajax({
            url: 'https://viacep.com.br/ws/'+formData.get('groupCEP').replace(/[^\d]+/g,'')+'/json/',
            type: 'GET',
            dataType: 'json',
            timeout: 8000,
            success: function(response){
                console.log(response);
                if(!isObject(response)){
                    if(isValidJSON(response)){
                        var data = JSON.parse(response);
                    }else{
                        error("<i class='icon fa-frown'></i> Estamos com problemas, tente novamente mais tarde.");
                    }
                }else{
                    var data = response;
                }
                if(data.erro === true){
                    closeLoadingOnButton(element, "auto");
                    returnInputError($("*[data-input-name=groupCEP]"));
                    error("O CEP informado é inválido.");
                }else{
                    ajax_validation = true;
                }  
            },
            error: function(jqXHR, textStatus, errorThrown){
                closeLoadingOnButton(element, "auto");
                returnInputError($("*[data-input-name=groupCEP]"));
                error("<i class='icon fa-frown'></i> Estamos com problemas, tente novamente mais tarde.");
            }
        });
        if(!ajax_validation){
            return;
        }
    }

    const add_group = await $.ajax({
        url: '/modules/Group.php?a=add-group',
        type: 'POST',
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 10000,
        success: function(response){
            if(!isObject(response)){
                if(isValidJSON(response)){
                    var data = JSON.parse(response);
                }else{
                    error("<i class='icon fa-frown'></i> Estamos com problemas, tente novamente mais tarde.");
                }
            }else{
                var data = response;
            }

            if(data.status === true){
                error(data.message).then(()=>{
                    window.location.reload();
                });
            }else{
                error(data.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR+ '\n' +textStatus + '\n' +errorThrown);
        },
        complete: function(jqXHR, textStatus){
            closeLoadingOnButton(element, "auto");
        }

    });
}

// Popup-card
function showEffect(element)
{
    $(element).animate({
        opacity: "show",
        top: "-=10"
    }, 300);
}
function hideEffect(element, callback)
{
    $(element).animate({
        opacity: "hide",
        top: "+=10"
    }, 100, function () { 
        $(this).css({
            "top": 0,
            "right": 0
        });
        $(this).hide();
        $(this).html("");
        $($(this).data("element-root")).removeClass("active");
        typeof callback == "function" && callback();
     });
}
function loadPopUpContent(async_load, right_value, element)
{
    $.ajax({
        url: "/d_views/"+async_load+".php",
        type: "GET",
        async: true,
        cache: false,
        timeout: 3000,
        beforeSend: function(jqXHR, settings){

            $(".popup-card").animate({
                top: $("header").height() + 10,
                right: right_value
            }, 1, function(){
                $(element).addClass("active");
                showEffect(".popup-card");
                $(".popup-card").data("element-root", element);
            });
            showLoadingOnElement($(".popup-card"));
        },
        success: function(data)
        {
            removeLoadingOnElement($(".popup-card"), function(){
                $(".popup-card").html(data);
            });
        },
        complete: function(jqXHR, textStatus){
            if(textStatus != "success")
            {
                displayLoadError($(".popup-card"), "Não foi possível carregar o conteúdo, tente novamente.");
                setTimeout(function(){
                    hideEffect(".popup-card", null);
                }, 3000)
            }
        }
    });
}
(function($) {
    $.fn.popUpCard = function() {
        $(".popup-card").hide();
        return this.each(function(index, element) {
            $(this).click(function(e){
                if(!isMobile() && !$(".popup-card").hasClass('rounded-bottom-sm')){
                    $(".popup-card").addClass('rounded-bottom-sm');
                }else if(isMobile() && $(".popup-card").hasClass('rounded-bottom-sm')){
                    $(".popup-card").removeClass('rounded-bottom-sm');
                }
                var async_load = $(this).data("dy-view");
                var offset = $(this).offset();
                var position_calc = offset.left + $(element).width() + parseFloat($(element).css("padding-right"), 10) + parseFloat($("header .header__wrapper .right").css("padding-right"), 10);
                var right_value = null;

                if($(window).width() <= 992){
                    right_value = 0;
                }else{
                    if(position_calc > ($(window).width() - position_calc) + $(".popup-card").width())
                    {
                        right_value = ($(window).width() - position_calc);
                    }else{
                        right_value = Math.abs(position_calc - $(".popup-card").width() - 10); 
                    }
                }

                if($(".popup-card").is(":visible"))
                {
                    if($(".popup-card").data("element-root") != element)
                    {
                        hideEffect(".popup-card", function(){
                            $($(".popup-card").data("element-root")).removeClass("active");
                            $(".popup-card").removeData("element-root");
                            // load content
                            loadPopUpContent(async_load, right_value, element);
                        });
                    }else{
                        hideEffect(".popup-card", null);
                        $("*[data-popup-card=true]").each(function(){
                            $(this).removeClass("active");
                        });
                    }
                }else{
                    //load content
                    loadPopUpContent(async_load, right_value, element);
                }
            });
        });
    };
}(jQuery));
// End popup-card

// Error
var errorTimeout = null;
async function error(errorMsg)
{
    let hideOpen =  async () => {
        if($(".error_message").is(':visible')){
            $(".error_message").toggle('blind', 200);
            clearTimeout(errorTimeout);
            errorTimeout = null;
            return;
        }
        return;
    }
    let promise = new Promise((resolve, reject) => {
        hideOpen().then(async () => {
            let content = await $(".error_message").html(
                '<div class="body">'+
                '<i class="icon warning fa-exclamation-circle"></i>'+
                `<div class="message">${errorMsg}</div>`+
                '<div class="timer"><div class="countdown"><div class="countdown-number"></div><svg><circle r="8" cx="10" cy="10"></circle></svg></div>'+
                '</div>').promise().done();
            let show = await $(".error_message").toggle('blind',200);
            errorTimeout = setTimeout(async () => {
                $(".error_message").html('');
                let hide = await $(".error_message").toggle('blind', 200);
                resolve();
            }, 5000);
        });
    })
    
    return await promise;
}


// Layout
$('section.page__content').height(function(){ //fix page__content height
    let page_header_height = $("main .page .header").height();
    let document_header_height = $("header").height();

    return $(window).height() - page_header_height - document_header_height - 5;
}); 

$(".loading_refresh").hide();
$('.collapisible-menu ul').hide();
$('.collapisible-menu').hide();
$("nav#mobile").hide();
$(document).ready(function(){
    $("*[data-popup-card=true]").popUpCard();
    $("nav").menu();
    $('.tooltipped').tooltip();
    setActiveNavItem();

    pullToRefresh({
        container: document.querySelector('body'),
        animates: ptrAnimatesMaterial2,

        refresh() {
          return new Promise(resolve => {
            setTimeout(resolve =>{
                window.location.reload();
            }, 1000)
          })
        }
      })

});  

function displayHiddenFlex(element, callback)
{
    element.css({
        "opacity": "0",
        "display": "flex"
    }).promise.done(function(){
        typeof callback == "function" && callback();
    });
}


// Actions
    // button actions
    $(document).on("click", "a[data-button-name]", $.throttle(function(e){
        let button_name = $(this).data("button-name");
        var $this = $(this);
        switch(button_name)
        {
            case 'logout':
                loadingOnButton($(this).find("i"));
                logout();
            break;
            case 'cadastrar':
                if($this.hasClass('noHover')){
                    $this.removeClass("noHover");
                }
                let form = $("#cadastroForm");
                if($(form)[0].checkValidity()){
                    cadastrar($this, form);
                }else{
                    $(form)[0].reportValidity();
                }
            break;
            case 'selector':
                loadingOnButton($(this).find("i"));
                eraseCookie('group-id');
                window.location.reload();
            break;
            case 'add_group_submit':
                if($this.hasClass('noHover')){
                    $this.removeClass("noHover");
                }
                let formGroup = $("#addGroupForm");
                addGroup($this, formGroup);
            break;
        }
    },3000));

    var $selector = $('.selector_options_wrapper').isotope({
            itemSelector: '.option',
            layoutMode: 'masonry',
            masonry: {
                columnWidth: 1,
                isFitWidth: true
            }
        });
    // selector options action 
    $(document).on('click', '.selector__body .selector_options_wrapper > div.option', function(e){
        var $this = $(this);
            let group_id = $(this).data('group-id');
            $this.siblings().toggle();
            $selector.isotope('layout');
            if($(this).data('group-id') !== undefined){
                $this.addClass('noHover');
                setCookie('group-id', group_id, 1);
                $this.html("").promise().done(()=>{
                    showLoadingOnElement($this);
                    setTimeout(()=>{
                        $this.fadeOut(500, ()=>{
                            window.location.reload();
                        })
                    }, 500)
                });
            }else{
                let action = $(this).data('option-action');
                switch(action){
                    case 'add_group':
                        $this.addClass('noHover');
                        $this.html("").promise().done(()=>{
                            $.ajax({
                                url: '/d_views/add_group.php',
                                type: 'GET',
                                async: true,
                                cache: false,
                                contentType: false,
                                processData: false,
                                timeout: 6000,
                                beforeSend: function(jgXHR, settings){
                                    showLoadingOnElement($this);
                                },
                                success: function(response){
                                    $('.selector__body').fadeOut(250, ()=>{
                                        $('.left .logo-app').hide(150, ()=>{
                                            $('.selector__body').html(response).promise().done(()=>{
                                                $('.selector__body').fadeIn(200);
                                            });
                                        });
                                    });
                                },
                                complete: function(jqXHR, textStatus, errorThrown){

                                }
                            });
                        });
                    break;
                    case 'enter_group':
                        console.log('enter_group');
                    break;
                }
            }
    });



