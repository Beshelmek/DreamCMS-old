toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right", // toast-top-right / toast-top-left / toast-bottom-right / toast-bottom-left
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

var alert = getCookie('dc_alert');
if(alert !== undefined){
    toastr["info"](alert.replace('+', ' '));
}

function processAction(data) {
    for(var action in data){
        var info = data[action];
        switch (action){
            case 'redirect':
                window.location.href = info;
                break;
            case 'reload':
                location.reload(Boolean.valueOf(info));
                break;
            case 'execute':
                eval(info);
                break;
        }
    }
    console.log(data);
}

function ajaxAction(url, data) {
    data['json_answ'] = 'true';
    data[$('#csrf-token').attr('csrf-key')] = $('#csrf-token').attr('csrf-value');

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        success: function(data){
            console.log(data['msg']);
            if(data['type'] == 'success'){
                if(data['msg'] != undefined && data['msg'] != ''){
                    toastr["success"](data['msg']);
                }
                if(data['actions'] != undefined && data['actions'] != ''){
                    processAction(data['actions']);
                }
            }else if (data['type'] == 'error'){
                if(data['msg'] != undefined && data['msg'] != ''){
                    toastr["error"](data['msg']);
                }
            }else{
                toastr["success"]('Ошибка типа ответа!');
            }
        },
        error: function(jqXHR, text, error) {
            console.log(jqXHR);
            console.log(text, error);
            toastr["error"](text);
        }
    });
}

$(document).ready(function() {
    $('select.mdb-select').material_select();
    $('[data-toggle="tooltip"]').tooltip();
});