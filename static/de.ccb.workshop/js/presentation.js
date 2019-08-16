$(document).ready(function() {

    var client_topic = 'de.ccb.workshoppy.client.' + window.workshoppy.guid,
        cards = [],
        categories = [],
        index = 1,
        unsortedCategoryTitle = $('<div class="row unsortedCategoryTitle"><div id="unsortedCategoryTitle" class="col">Unsortiert</div>'),
        deleteCategoryId;

    var connection = new autobahn.Connection({
        url: window.WS_CONFIG.url,
        realm: "workshoppy"
    });

     //WS management stuff
    const successNotification = window.createNotification({
        closeOnClick: true,
        displayCloseButton: false,
        positionClass: 'nfc-top-right',
        onclick: false,
        showDuration: 4000,
        theme: 'success'
    });

    const errorNotification = window.createNotification({
        closeOnClick: true,
        displayCloseButton: false,
        positionClass: 'nfc-top-right',
        onclick: false,
        showDuration: 4000,
        theme: 'error'
    });
            
    connection.onopen = function(session, details) {
        $('#connection-close').hide();
        session.subscribe(client_topic, function (args) {
            add_card(args[0]);
        });
    };

    connection.onclose = function (reason, details) {
        setTimeout(function() {
            $('#connection-close').show();
        }, 1000);
        console.warn('WebSocket connection closed: ' + reason);
    };
    
    $('#fullscreen-button').on('click', function(e) {
        e.preventDefault();
        var elem = elem || document.documentElement;
        if (!document.fullscreenElement && !document.mozFullScreenElement &&
           !document.webkitFullscreenElement && !document.msFullscreenElement) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
              } else if (elem.msRequestFullscreen) {
                  elem.msRequestFullscreen();
              } else if (elem.mozRequestFullScreen) {
                  elem.mozRequestFullScreen();
              } else if (elem.webkitRequestFullscreen) {
                  elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
              }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
              } else if (document.msExitFullscreen) {
                  document.msExitFullscreen();
              } else if (document.mozCancelFullScreen) {
                  document.mozCancelFullScreen();
              } else if (document.webkitExitFullscreen) {
                  document.webkitExitFullscreen();
              }
          }
    });

    $('#qrcode-show').on('click', function(e) {
        e.preventDefault();
        $('#toggle-qrcode').show();
        $('#item-qrcode').show();
        $('#stage-session').hide();
        $(this).hide();
        $(this).nextAll('#qrcode-exit').show();
    });

    $('#qrcode-exit').on('click', function(e) {
        e.preventDefault();
        $('#toggle-qrcode').hide();
        $('#item-qrcode').hide();
        $('#stage-session').show();
        $(this).hide();
        $(this).prevAll('#qrcode-show').show();
        $('#qrcode-show').prop('disabled', false);
    });

    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    function htmlDecode(value) {
        return $('<div/>').text(value).html();
    }

    function add_card(data) {
        var card = $('<div data-index="' + index +'" class="alert alert-warning"><p><b>' + htmlDecode(data.user_id) + ':</b> ' + htmlDecode(data.msg) + '</p></div>'),
            category = $('.sortedMessages[data-category="' + data.category + '"]');
        data.index = index;
        cards.push(data);
        index = index + 1;
        if (category.length > 0) {
            setTimeout(function() {
                card.addClass('fade-in');
                category.append(card);
            }, 30);
        } else {
            $('#message_output').append(card);
        }
    }

    function add_category(data) {
        var categoryTitle = $('<div class="row"><div id="categoryTitle-' + data.id + '" class="col categoryTitle" data-category="' + data.id + '">' + htmlDecode(data.title) + '</div></div>'),
            categoryBox = $('<div data-category="' + data.id + '" class="connectedSortable sortedMessages"></div>'),
            quote_title =  "'" + data.title + "'",
            closeButton = $('<a class="boxclose" data-dialog="delete" data-form-id="confirm-delete" data-dialog-heading="Löschen bestätigen" data-dialog-text="Möchten Sie diese Kategorie ' + quote_title + ' wirklich löschen?" data-dialog-cancel-label="Abbrechen" data-recursive="false" data-category= "' + data.id + '" data-relocate="" role="button" aria-pressed="true"></a>'),
            lineal =  $('<hr class="style1">');
        $('#message_output').addClass('categoryBox');
        if ($('.unsortedCategoryTitle').length == 0) {
            $('#message_output').prepend(unsortedCategoryTitle);
        }
        $('#category_output').append(categoryBox);
        categoryBox.append(categoryTitle);
        categoryBox.append(closeButton);
        categoryBox.append(lineal);
        categories.push(data);
        initSortable(data.id);
    }

    function titleClicked() {
        var divText = $(this).text(),
            editableText = $('<input id="' + $(this).attr('id') + '" class="col form-control inputName" data-category="' + $(this).data('category') + '" style="width: 280px" />');
        editableText.val(divText);
        $(this).replaceWith(editableText);
        editableText
            .focus()
            .on('blur', saveCategory)
            .on('keyup', function(e) {
                if (e.keyCode === 13) {
                    saveCategory.apply(this);
                }
            });
    }

    function saveCategory() {
        var name = htmlDecode($(this).val()),
            params = {title: name},
            quote_name =  "'" + name + "'";

        $(this).closest('.sortedMessages').find('.boxclose').data('dialog-text', 'Möchten Sie diese Kategorie ' + quote_name + ' wirklich löschen?');
        $.ajax({
            type: 'POST',
            url: '/category/update/' + $(this).data('category') + '/',
            data: params,
            success: function (data) {
                var viewableText = $('<div id="categoryTitle-' + data.id + '" class="col categoryTitle" data-category="' + data.id + '"></div>');
                viewableText.html(name);
                $('.inputName').replaceWith(viewableText);
                // setup the click event for this new div
                $(viewableText).click(titleClicked);
                updateCategoryTitle(data.id, data.title);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    $('#createCategory').on('click', function(e) {
        e.preventDefault();
        $('#message_output').removeClass('disable-sort');
        $.ajax({
            type: 'POST',
            url: '/category/create/' + $(this).data('session') + '/',
            success: function (data) {
                add_category(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    function updateCategoryTitle(key, value) {
        for (var i = 0; i < categories.length; i++) {
            if (categories[i].id == key) {
                categories[i].title = value;
                break;
            }
        }
    }

    function deleteCategory(key) {
        for (var i = 0; i < categories.length; i++) {
            if (categories[i].id == key) {
                categories.splice(i, 1);
                break;
            }
        }
        if(Object.keys(categories).length == 0){
            $('#message_output').removeClass('connectedSortable');
            $('#message_output').addClass('disable-sort');
            $('#message_output').find('.unsortedCategoryTitle').remove();
        } else {
            $('#message_output').removeClass('disable-sort');
        }
    }

    function initSortable(id) {
        if (!$('#message_output').hasClass('connectedSortable')) {
            $('#message_output').sortable({
                update: function(event, ui) {
                    ui.placeholder.css({visibility: 'visible', border: '2px solid yellow'});
                    cards.forEach(function (item) {
                        if (item.index == $(ui.item).data('index')) {
                            item.category = null;
                        }
                    });
                },
                items: '.alert',
                cancel: '.disable-sort',
                connectWith: '.connectedSortable'
            }).disableSelection();
            $('#message_output').addClass('connectedSortable');
        }

        $('[data-category="' + id + '"].sortedMessages').sortable({
            items: '.alert',
            cancel: '.categoryTitle',
            connectWith: '.connectedSortable',
            update: function(event, ui) {
                ui.placeholder.css({visibility: 'visible', border: '2px solid yellow'});
                cards.forEach(function (item) {
                    if (item.index == $(ui.item).data('index')) {
                        item.category = $(event.target).attr('data-category');
                    }
                });
              }
        }).disableSelection();
    }
    
    $(document).on('click', '.categoryTitle', titleClicked);

    $(document).on('click', '.boxclose', function(e) {
        e.preventDefault();
        deleteCategoryId = $(this).closest('.sortedMessages').attr('data-category');
    });

  $('body').on('dialogdeleted', '[data-dialog="delete"]', function() {
      $.ajax({
        type: 'POST',
        url: '/category/delete/' + deleteCategoryId + '/',
        success: function(data) {
            deleteCategory(data.id);
            $('[data-category="' + data.id + '"].sortedMessages').find('.alert').each(function() {
                $(this).detach().appendTo($('#message_output'));
            });
            $('[data-category="' + data.id + '"].sortedMessages').remove();
            successNotification({
                message: data.response
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            errorNotification({
                message: errorThrown
            });
        }
      });
  });

    window.workshoppy.start_session = function(config) {
        $('#question').text(config.question);
        $('#createCategory').data('session', config.guid);
        $('#stage-session').show();
        $('#createCategory').hide();
        $('#fullscreen-button').show();
        $('#qrcode-show').show();
        $('#stage-welcome').hide();
    };
    window.workshoppy.end_session = function() {
        index = 1;
        $('#stage-welcome').show();
        $('#fullscreen-button').show();
        $('#stage-session').hide();
        $('#qrcode-show').hide();
        $('#toggle-qrcode').hide();
        $('#item-qrcode').hide();
        $('#qrcode-exit').hide();
        $('#createCategory').hide();
    };
    
    window.workshoppy.session_stop_input = function() {
        $('#createCategory').show();
    };

    window.workshoppy.get_categories = function() {
        return categories;
    };

    window.workshoppy.set_categories = function(input) {
        categories = [];
        $('#category_output').empty();
        $.each(input, function(index, category) {
            add_category(category);
        });

        if(Object.keys(categories).length == 0){
            $('#message_output').removeClass('connectedSortable');
            $('#message_output').addClass('disable-sort');
        } else {
            $('#message_output').removeClass('disable-sort');
        }
    };

    window.workshoppy.get_cards = function() {
        return cards;
    };

    window.workshoppy.set_cards = function(input) {
        cards = [];
        $('#message_output').empty();
        $('#message_output').append(unsortedCategoryTitle);
        if(Object.keys(categories).length == 0){
            $('#message_output').empty();
        }
        input.forEach(function(card) {
            add_card(card);
        });
    };

    connection.open();

    $('#stage-session').hide();
    $('#item-qrcode').hide();

    if (window.parent.opener) {
        window.parent.opener.workshoppy.register_presentation(window);
    }
});
