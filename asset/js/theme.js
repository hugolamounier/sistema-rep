var mobile_menu = false;
var primary_color = "#6a1b9a";
var label_color = "#9e9e9e";
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
            clearInputError($("*[data-input-name=userEmail]"));
            clearInputError($("*[data-input-name=userPassword]"));
            showLoadingOnButton(element);
        },
        success: function(response){
            var data = JSON.parse(response);
            if(data.status === true)
            {
                window.location.reload();
            }else{
                returnInputError($("*[data-input-name=userEmail]"));
                returnInputError($("*[data-input-name=userPassword]"));
            }
        },
        error: function(jqXHR, textStatus, errorThrown){

        },
        complete: function(jqXHR, textStatus){
            closeLoadingOnButton(element);
        }
    });
}
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
    element.find("input").addClass("error");
    element.find(".input-flag").html("<i class=\"icon fa-exclamation-circle\"></i>");
}
function clearInputError(element)
{
    element.find("input").removeClass("error");
    element.find(".input-flag").html("");
}

// End Form input

// Loading
function showLoadingOnElement(element)
{
    var DOM_element = "<div class=\"loading\"><div class=\"lds-dual-ring\"></div></div>";
    element.append(DOM_element);
    element.find(".loading").fadeIn(100);
}
function removeLoadingOnElement(element, callback)
{
    element.find(".loading").fadeOut(100, function(){
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
function showLoadingOnButton(element)
{
    if(element_content != null)
    {
        element_content = null;
    }
    element_content = element.html();
    element.animate({
        "flex-basis": "32px",
    }, 600, function(){
        element.html("<i class=\"loading\"></i>");
        element.find("i").html("<div class=\"lds-dual-ring\"></div>");
    });
}
function closeLoadingOnButton(element)
{
    element.animate({
        "flex-basis": "50%",
    }, 600, function(){
        element.html(element_content);
        element_content = null;
        element.addClass("noHover");
        if(element.hasClass("simulateHover"))
        {
            $("a[data-action=login]").removeClass("simulateHover");
        }
    });
}

// end loading
// Navegation
var timeout;
(function( $ ){
    $.fn.menu = function() {
        $(document).on("mouseenter", "nav#desktop", function(){
            var $this = $(this);
            if(timeout != null)
            {
                clearTimeout(timeout);
                timeout = null;
            }
            timeout = setTimeout(function (){
                $("nav#desktop > .nav__groups").hide(0, function(){
                    $this.animate({
                        width: "250",
                    }, 200, function(){
                        $("nav > ul.collapisible-menu").show();
                        $this.find("li").addClass("full-menu");
                    });
                    
                });
            }, 100);
        });
        $(document).on("mouseleave", "nav#desktop", function(){
            var $this = $(this);
            if(timeout != null)
            {
                clearTimeout(timeout);    
                timeout = null;
            }
            timeout = setTimeout(function(){
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
            }, 150);
        });
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
    if(!$(event.target).hasClass("popup-card") && !$(event.target).parents(".popup-card").length && event.target.tagName != "HEADER" && !$(event.target).parents("header").length)
    {
        if(popupCard.is(":visible"))
        {
            hideEffect(".popup-card");
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
// End Navegation
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
                var async_load = $(this).data("dy-view");
                var offset = $(this).offset();
                var position_calc = offset.left + $(element).width() + parseFloat($(element).css("padding-right"), 10) + parseFloat($("header .header__wrapper .right").css("padding-right"), 10);                var right_value = null;

                if(position_calc > ($(window).width() - position_calc) + $(".popup-card").width())
                {
                    right_value = ($(window).width() - position_calc);
                }else{
                    right_value = Math.abs(position_calc - $(".popup-card").width() - 10); 
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