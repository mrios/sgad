var main_msg = '#main_msg';
var default_timeout = 3;

function notify(msg, msg_class){
    
    $(main_msg).text('').removeClass().addClass(msg_class).text(msg).fadeIn('fast');
    setTimeout(function(){
        $(main_msg).fadeOut();
    }, default_timeout*1000);
}

function ajax_min(url, selector, data){
    
    var url_ajax = '<img src="../images/icons/ajax-loader.gif">';
    
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: url,
        data: data,
        beforeSend:function(){
            $(selector).html(url_ajax);
        },
        success: function (html) {
            $(selector).html(html)
        },
        timeout:10000,
        error: error
    });
}

function ajax_notify(url, data){
    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: url,
        data: data,
        beforeSend:function(){
            notify('Procesando solicitud....', 'processing');
        },
        success: function (jsonData) {
            datos = eval('(' + jsonData + ')');
            notify(datos.msg, datos.msg_class);
        },
        timeout:10000,
        error: error
    });
}

function error(){
    $(main_msg).html('');
    $(main_msg).html('No se ha podido procesar la solicitud, por favor intentelo nuevamente.');
}

function my_datepicker(selector){

    $(selector).datepicker( {
                changeMonth: true,
		changeYear: true,
                yearRange: 'c-120:c+10'
            },
            $.datepicker.regional['es']
    );
}

function activeDefaults(){
    my_datepicker('.date');
    activeButtons();
}

function activeButtons(){
    $("input[type=button]").button();
    $("input[type=submit]").button();
    $("input[type=reset]").button();
}
