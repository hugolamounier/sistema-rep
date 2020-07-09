$(".error_handler").hide();
var NETWORK_STATE = true;
window.addEventListener('online', function(e){
    if(!NETWORK_STATE)
    {
        clearError();
    }
});
window.addEventListener('offline', function(e){
     NETWORK_STATE = false;
     let errorMsg = "Você está sem conexão com a internet.<br><br>Tentando reconectar";
     errorHandling(errorMsg);
});

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