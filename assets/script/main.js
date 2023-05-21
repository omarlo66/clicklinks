$(document).ready(function() {
    show_loading();
}
);
function show_loading(time=3000){
    $('.loading_page').show();
    $('.loading_page').css({
        'display': 'flex',
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'width': '100%',
        'height': '100%',
    })
    setTimeout(()=>{
        $('.loading_page').css('display', 'none');
    }, time);
}

function loading_bar(element,time=3000){
    $(element).append('<div class="loading_bar"></div>');
    $('.loading').animate( 'loading_bar' , time);
}


function sendRequest(url, data, callback, type){
    $.ajax({
        url: url,
        type: type,
        data: data,
        success: callback
    });
}

function submitForm(form, callback){
    var data = $(form).serialize();
    var url = $(form).attr('action');
    var type = $(form).attr('method');
    sendRequest(url, data, callback, type);
    return loading(form);
}

function submitFormWithFile(form, callback){
    var data = new FormData(form);
    var url = $(form).attr('action');
    var type = $(form).attr('method');
    sendRequest(url, data, callback, type);
}

function notification(type,msg,time=7000){
    var notification = '<div class="notification '+type+' alert-dismissible fade show" role="alert">'+
                            '<button type="button" class="close small_btn" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                            '<strong>'+msg+'</strong>'+
                        '</div>';
        
        $('.msg').append(notification);
        loading_bar('.notification',time);
        $('.notification .close').click(()=>{
            $('.notification').remove();
        });
        setTimeout(function() {
            $('.notification').remove();
        }, time);

    return notification;
}

function Up_btn(){
    var upBtn = '<div class="up-btn">'+
                    '<button class="up_btn"<i class="fa fa-chevron-up" aria-hidden="true"></i></button>'+
                '</div>';
    let body = $('#body');
    $(body).append(upBtn);
    $(upBtn).click(()=>{
        $('body').animate({scrollTop: 0}, 800, 'swing');
    });
}