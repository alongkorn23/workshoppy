$(document).ready(function() {
    
    const successNotification = window.createNotification({
        closeOnClick: true,
        displayCloseButton: false,
        positionClass: 'nfc-top-right',
        onclick: false,
        showDuration: 3500,
        theme: 'success'
    });
    
    const errorNotification = window.createNotification({
        closeOnClick: true,
        displayCloseButton: false,
        positionClass: 'nfc-top-right',
        onclick: false,
        showDuration: 3500,
        theme: 'error'
    });

    $('#workshop-participants').on('submit', function (e) {
        e.preventDefault();
        var email = $(this).find('input[type="email"]').val(),
        params = {email: email};
        
        $.ajax({
            type: 'POST',
            url: '/mail/ajax/' + window.workshoppy.guid,
            data: params,
            statusCode: {
                200: function (data) { // success
                    successNotification({ 
                        message: data.response
                    });
                },
                404: function () { // custom error
                    errorNotification({ 
                        title: 'Fehlerstatus: 404',
                        message: 'Die Einladungsmail konnte nicht gesendet werden.' 
                    });
                  
                },
                500: function () { // server error
                    errorNotification({ 
                        title: 'Fehlerstatus: 500',
                        message: 'Die Einladungsmail konnte nicht gesendet werden.' 
                    });
                }
            }
            
        });
        $(this).find('input[type="email"]').val('');
    });
});