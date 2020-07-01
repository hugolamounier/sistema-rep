var mobile_menu = false;
function login()
{
    $.ajax({
        url: 'controller/auth.php',
        type: 'POST',
        data: $("#loginForm").serialize(),
        success: function(data)
        {
            if(data == "ok")
            {
                window.location.reload();
            }else{
                alert(data);
            }
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
            "left": 0
        });
        $(this).hide();
        $(this).html("");
        $($(this).data("element-root")).removeClass("active");
        typeof callback == "function" && callback();
     });
}
(function($) {
    $.fn.popUpCard = function() {
        $(".popup-card").hide();
        return this.each(function(index, element) {
            $(this).click(function(e){
                var async_load = $(this).data("dy-view");
                var offset = $(this).offset();
                if($(".popup-card").is(":visible"))
                {
                    if($(".popup-card").data("element-root") != element)
                    {
                        hideEffect(".popup-card", function(){
                            $($(".popup-card").data("element-root")).removeClass("active");
                            $(".popup-card").removeData("element-root");
                            $.ajax({
                                url: "/d_views/"+async_load+".php",
                                type: "GET",
                                success: function(data)
                                {
                                    $(".popup-card").html(data);
                                    $(".popup-card").animate({
                                        top: $("header").height() + 10,
                                        left: offset.left - $(element).width() - $(element).css("padding-right").replace(/[^-\d\.]/g, '') - $("header .header__wrapper .right").css("padding-right").replace(/[^-\d\.]/g, '')
                                    }, 1, function(){
                                        $(element).addClass("active");
                                        showEffect(".popup-card");
                                        $(".popup-card").data("element-root", element);
                                    });
                                }
                            }); 
                        });
                    }else{
                        hideEffect(".popup-card", null);
                        $("*[data-popup-card=true]").each(function(){
                            $(this).removeClass("active");
                        });
                    }
                }else{
                    $.ajax({
                        url: "/d_views/"+async_load+".php",
                        type: "GET",
                        success: function(data)
                        {
                            $(".popup-card").html(data);
                            $(".popup-card").animate({
                                top: $("header").height() + 10,
                                left: offset.left - $(element).width() - $(element).css("padding-right").replace(/[^-\d\.]/g, '') - $("header .header__wrapper .right").css("padding-right").replace(/[^-\d\.]/g, '')
                            }, 1, function(){
                                $(element).addClass("active");
                                showEffect(".popup-card");
                                $(".popup-card").data("element-root", element);
                            });
                        }
                    });
                }
            });
        });
    };
}(jQuery));
// End popup-card