
$(".error_handler").hide();

const isAppFullScreen = () => {
    let screenHeight = window.screen.height;
    let viewPortHeight = window.innerHeight;
    
    if(viewPortHeight == screenHeight){
        return true;
    }else{
        return false;
    }
}

// NETOWRK_STATE change listener
c = {
    NETWORK_STATE_I: true,
    NETWORK_STATE_LISTENER: function(val) {},
    set NETWORK_STATE(val){
        this.NETWORK_STATE_I = val;
        this.NETWORK_STATE_LISTENER(val);
    },
    get NETWORK_STATE(){
        return this.NETWORK_STATE_I;
    },
    registerListener: function(listener){
        this.NETWORK_STATE_LISTENER = listener;
    }
};
// end

window.addEventListener('load', (e) => {
    // Network initial state
    if(navigator.onLine === false){
        c.NETWORK_STATE = false;
    }
    
});

window.addEventListener('resize', (e) => {

});



// Network state handler
c.registerListener(function(val){
    setTimeout(function(){
        if(val == false)
        {
            let errorMsg = "Você está sem conexão com a internet.<br><br>Tentando reconectar";
            errorHandling(errorMsg);
        }else if(val == true){
            clearError();
        }
    }, 500);
});
if(navigator.onLine == false)
{
    c.NETWORK_STATE = false;
}
window.addEventListener('online', (e) => {
    if(c.NETWORK_STATE == false)
    {
        c.NETWORK_STATE = true;
    }
});
window.addEventListener('offline', (e) => {
     if(c.NETWORK_STATE == true)
     {
        c.NETWORK_STATE = false;
     }
});

// network state

// PWA Install

window.addEventListener('beforeinstallprompt', function(event) {
    console.log("install fired");
});

// 


// Handle back button
window.addEventListener('load', function(e){
    window.history.pushState({noBackExitsApp: true}, '')
});

window.addEventListener('popstate', function(e){
    if(e.state && event.state.noBackExitsApp){
        window.history.pushState({noBackExitsApp: true}, '');
    }
});

window.addEventListener("backbutton", function(e){
    e.preventDefault();
    if($("nav#mobile").is(":visible"))
    {   
        $("nav#mobile").toggle("slide", function(){
            mobile_menu = false;
        });
        return false;
    }
})

async function clearError()
{
    let error_content = await $(".error_handler").html("").promise();
    let error_hide = await $(".error_handler").slideToggle(200);
    window.location.reload(); 
}

async function errorHandling(errorMsg){
    let content = await $(".error_handler").html(
        "<div class=\"wrapper\">"+
        "<i class=\"icon fa-sad-tear\"></i>"+
        "<p>"+errorMsg+"</p>"+
        "<i class=\"icon fa-redo-alt\"></i>"+
        "</div>"
    ).promise().done();

    let error_display = await $(".error_handler").slideToggle(200);

    return;
}