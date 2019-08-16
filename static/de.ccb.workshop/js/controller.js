$(document).ready(function() {

    var controller_topic = 'de.ccb.workshoppy.controller.' + window.workshoppy.guid,
        client_topic = 'de.ccb.workshoppy.client.' + window.workshoppy.guid,
        presentation,
        session_data = window.workshoppy.sessiondata,
        session_categories = window.workshoppy.sessioncategories,
        active_session,
        clientQuestion,
        is_running,
        is_closed,
        presentationQuestion,
        start_session_helptext = window.workshoppy.start_session_helptext,
        stop_session_helptext = window.workshoppy.stop_session_helptext,
        edit_session_helptext = window.workshoppy.edit_session_helptext,
        delete_session_helptext = window.workshoppy.delete_session_helptext,
        no_connection_helptext = window.workshoppy.no_connection_helptext,
        stop_workshop_helptext = window.workshoppy.stop_workshop_helptext;

    var connection = new autobahn.Connection({
        url: window.WS_CONFIG.url,
        realm: "workshoppy"
    });

    window.workshoppy.register_presentation = function(win) {
        presentation = win;
        presentation.onbeforeunload = function () {
            if (active_session) {
                $('.session-stop[data-session="' + active_session.guid + '"]').trigger('click');
            }
            presentation = null;
        };        
        if (active_session) {
            start_session(active_session.guid);
        }
    };

    window.addEventListener("beforeunload", function(e) {
        if (presentation && !is_closed) {
            e.returnValue = 'Do you want to close the running session?';
        }
    });
    
    window.addEventListener("unload", function(e) {
        if (presentation) {
            presentation.close();
        }
    });

    connection.onopen = function(session, details) {
        $('#connection-close').hide();
        add_controls(session);     
        enable_controls();
        if (active_session){
            toggle_button($('.session-start'), true);
            $('.session-start').attr('title', start_session_helptext);
            toggle_button($('.session-stop-input[data-session="' + active_session.guid + '"]'), false);
            toggle_button($('.session-stop[data-session="' + active_session.guid + '"]'), false);
            stop_active_session(session);
            $('.session-stop-input[data-session="' + active_session.guid + '"]').on('click');
            $('.session-stop[data-session="' + active_session.guid + '"]').on('click');
        }
                
        session.subscribe(client_topic + '.connect', function(args) {
            if (active_session) {
                session.publish(controller_topic + '.' + args[0].uuid, [{
                    stage: 'session',
                    msg: active_session.question,
                    getCategories: active_session.categories
                }]);
            }
        });
    };

    connection.onclose = function (reason, details) {
        setTimeout(function() {
            $('#connection-close').show();
        }, 1000);
        disable_controls();
        $('#session-list').off('click');
        if(active_session){
          toggle_button($('.session-stop-input[data-session="' + active_session.guid + '"]'), true);
          toggle_button($('.session-stop[data-session="' + active_session.guid + '"]'), true);
          $('.session-stop-input[data-session="' + active_session.guid + '"]').attr('title', no_connection_helptext);
          $('.session-stop[data-session="' + active_session.guid + '"]').attr('title', no_connection_helptext);
        }   
        console.warn('WebSocket connection closed: ' + reason);
    };

    connection.open();
    
    $('#controller-button').on('click', function(e) {
        e.preventDefault();

        if (!presentation) {
            window.open($(this).attr('href'), 'Presentation', 'menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');
        } else {
            presentation.focus();
        }
    });
    
    function showResultButton() {
        var isResultEmpty = true;
        $.each(session_data, function (i) {
            $.each(session_data[i], function (val) {
                if (val != null) {
                    isResultEmpty = false;
                    return false;
                }
            });
            if (isResultEmpty){
                toggle_button($('#showResult-button'), true);
            } else {
                toggle_button($('#showResult-button'), false);
            } 
        });     
    }
    
    function sync_presentation_data(guid) {
        session_data[guid] = presentation.workshoppy.get_cards();
        session_categories[guid] = presentation.workshoppy.get_categories();
        $.post(window.workshoppy.save_data_prefix + guid + '/', {data: session_data[guid]});
    }

    function start_session(guid) {
        if (presentation) {
            presentation.workshoppy.start_session(active_session);
            if (session_data.hasOwnProperty(guid)) {
                presentation.workshoppy.set_categories(session_categories[guid]);
                presentation.workshoppy.set_cards(session_data[guid]);
            } else {
                presentation.workshoppy.set_categories([]);
                presentation.workshoppy.set_cards([]);
            }
        }
    }
    
    function enable_controls()
    {
        toggle_button($('.session-start, .stopWSButton'), false);        
    }
    
    function disable_controls()
    {
        toggle_button($('.session-start, .stopWSButton'), true);
        $('.session-start, .stopWSButton').attr('title', no_connection_helptext);
        if(active_session){
            $('.session-start').attr('title', start_session_helptext);
          } 
    }
    
    function toggle_button(element, disabled) {
        element.prop('disabled', disabled);   
          if (!disabled) {
              element.removeAttr('title');              
          }
    }
    
    function stop_active_session(session) {
        session.publish(controller_topic, [{
            stage: 'welcome'
        }]);
    }
          
    function add_controls(session) {
        // Events
        $('#session-list')
            .on('click', '.session-start', function(e) {
                e.preventDefault();  
                presentationQuestion = $(this).attr('data-question');
                $('.session-start').attr('title', start_session_helptext);
                $('.editButton').attr('title', edit_session_helptext);
                $('.deleteButton').attr('title',  delete_session_helptext);
                $('.stopWSButton').attr('title', stop_workshop_helptext);
                is_running = true;

                active_session = {
                    question : presentationQuestion, 
                    guid: $(this).data('session'),
                    categories: session_categories[$(this).data('session')]                
                }; 
                clientQuestion = active_session.question;
                session.publish(controller_topic, [{
                    stage: 'session',
                    msg: clientQuestion,
                    getCategories: active_session.categories
                }]);
                         
                $(this)
                    .hide()
                    .parent()
                    .find('.session-stop, .session-stop-input').show()
                    .closest('li').addClass('session-running');
                toggle_button($('.session-start'), true);
                toggle_button($(this).parent().find('.session-stop, .session-stop-input'), false);
                toggle_button($('.editButton, .deleteButton'), true);
                toggle_button($('.stopWSButton'), true);
                start_session($(this).data('session'));
                $('.tab-content').find('#controller-button').trigger('click');
                $(this).trigger('blur');

            })
            .on('click', '.session-stop', function(e) {
                e.preventDefault();
                stop_active_session(session);
                active_session = null;
                is_running = false;
                
                $(this)
                    .hide()
                    .parent()
                    .find('.session-stop-input').hide()
                    .closest('li').removeClass('session-running');
                $(this).parent().find('.session-start').show();
                toggle_button($('.editButton, .deleteButton'), false);
                toggle_button($('.session-start'), false);
                toggle_button($('.stopWSButton'), false);
                if (presentation) {
                    sync_presentation_data($(this).data('session'));
                    presentation.workshoppy.end_session();
                }
                showResultButton();
                $(this).trigger('blur');

            })
            .on('click', '.session-stop-input', function(e) {
                e.preventDefault();
                stop_active_session(session);
                presentation.workshoppy.session_stop_input();
                $(this).hide();
                $(this).trigger('blur');
            });
    }
    $('#showResult-button').on('click', function(e) {
        e.preventDefault();
        window.open($(this).attr('href'));
    });
    
    $('#confirmModal').find('.modal-footer').on('click', '.confirm-button', function() {
        if(presentation){
            is_closed = true;
        }
    });
    
    $('.session-stop, .session-stop-input').hide();
    toggle_button($('.session-start, .editButton, .deleteButton'), false);
    $( "#dialog-confirm" ).dialog("hide");
    showResultButton(); 
            
    if ($('#session-list li').length === 0) {
        toggle_button($('#showResult-button'), true);
    }
    
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

    $('body')
        .on('dialogdeleted', '[data-dialog="delete"]', function(event, message) {
            var guid = $(this).data('guid');
            if (message.type == 'error') {
                errorNotification({
                    title: message.title,
                    message: message.message
                });
            } else {
                successNotification({
                    title: message.title,
                    message: message.message
                });
                $(this).closest('li').remove();
            }
            if ($('#session-list li').length === 0) {
                $('#session-list').prev('.helptext').removeClass('d-none');
                toggle_button($('#showResult-button'), true);
            }
            session_data[guid] = [];
            if(session_data[guid].length === 0) {
               toggle_button($('#showResult-button'), true);
            }
        })
        .on('dialogsaved', '#midcom-dialog', function(event, data) {
            if ($('#session-list li').length === 0) {
                location.href = location.href;
                return;
            }
            var label = data.title || data.question;
            $.ajax({
                type: 'POST',
                url: '/get/category/' + data.guid + '/',
                success: function (response) {
                    session_categories[data.guid] = response.categories;
                    var button = $('.session-start[data-session="' + data.guid + '"]');
                    button.attr('data-question', response.question);                  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
                          
            if ($('#session-list [data-guid="' + data.guid + '"]').length > 0) {
                var row = $('#session-list [data-guid="' + data.guid + '"]').closest('li');
                row.find('.session-label').text(label);
                return;
            }                
            var new_row = $('#session-list li').first().clone(),
                old_guid = new RegExp(new_row.find('.deleteButton').data('guid'));
            new_row.removeClass('session-running');
            new_row.find('.object-controls').show();
            new_row.find('.session-start').attr('data-session', new_row.find('.session-start').attr('data-session').replace(old_guid, data.guid));
            new_row.find('.session-stop').attr('data-session', new_row.find('.session-stop').attr('data-session').replace(old_guid, data.guid));
            new_row.find('.session-label').text(label);
            new_row.find('.editButton').attr('href', new_row.find('.editButton').attr('href').replace(old_guid, data.guid));
            new_row.find('.deleteButton')
                .attr('href', new_row.find('.deleteButton').attr('href').replace(old_guid, data.guid))
                .attr('data-guid', data.guid)
                .attr('data-dialog-text', label + ' löschen');
            new_row.appendTo($('#session-list'));
            if (is_running) {
                new_row.find('.session-stop, .session-stop-input').hide();
                toggle_button(new_row.find('.editButton, .deleteButton'), true);
            }
            new_row.find('.session-stop, .session-stop-input').hide();
            $('#session-list').prev('.helptext').addClass('d-none');
        });
});
