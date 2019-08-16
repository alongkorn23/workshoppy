$(document).ready(function() {

    var controller_topic = 'de.ccb.workshoppy.controller.' + window.workshoppy.guid,
        client_topic = 'de.ccb.workshoppy.client.' + window.workshoppy.guid,
        username,
        categories = [],
        uuid = almost_uuidv4();

    var connection = new autobahn.Connection({
        url: window.WS_CONFIG.url,
        realm: "workshoppy"
    });

    connection.onopen = function(session, details) {
        $('#connection-close').hide();
        $('#save-button').prop('disabled', false);
        $('#submit-button').prop('disabled', false);
        session.subscribe(controller_topic, function(args) {
            update_stage(args[0]);
        });
        
        // These two are basically to join a running session
        session.subscribe(controller_topic + '.' + uuid, function(args) {
            update_stage(args[0]);
        });

        session.publish(client_topic + '.connect', [{
            'user_id': username,
            'uuid': uuid
        }]);

        if (localStorage.getItem('username')){
            $('#loginByUsername').hide();
            var form = $('#answer');
            username = localStorage.getItem('username');
            form.find('#displayName').text(username);
            $('#loginName').text(username);
            form.show();
            $('#stage-waiting').show();
            $('.loginNav').show();
        } else {
            $('#loginByUsername').show();
        }
        add_controls(session);
        $('#stage-waiting').show();
    };

    connection.onclose = function (reason, details) {
        setTimeout(function() {
            $('#connection-close').show();
            $('#save-button').prop('disabled', true);
            $('#submit-button').prop('disabled', true);
        }, 1000);
        $('#answer').off('submit');

        console.warn('WebSocket connection closed: ' + reason);
    };

    connection.open();

    $('#register').on('submit', function(e) {
        e.preventDefault();
        $('#register').hide();
        var form = $('#answer');
        form.show();
        username = $('#register').find('input[type="text"]').val();
        form.find('#displayName').text(username);
        $('#loginName').text(username);
        localStorage.setItem('username', username);
        $('#loginByUsername').hide();
        $('.loginNav').show();
    });

    $('#log-out').on('click', function(e) {
        e.preventDefault();
        $('#loginByUsername').show();
        $('#register').show();
        localStorage.removeItem('username');
        $('.loginNav').hide();
    });
        
    function update_stage(data) {
        $('.stage').hide();
        if (data.stage === 'session') {
            $('#question').text(data.msg);
            $('#loginName').text(username);
            $('#stage-session').show();
            
            for(var key in data.getCategories){
              var str = data.getCategories[key];
              categories.push(str);
            }
            
            if(categories.length == 0){
              $('.custom-select').hide();
              $('#answer').find('#selectCategory').hide();
            }
            categories.forEach(function(item) {
              var selectOptions = $('<option value="' + item.id + '"> '+ item.title + '</option>');
              $('.custom-select').append(selectOptions);
              $('.custom-select').show();
            });            
        } else {
            $('#stage-waiting').show();
            categories = [];
            $('.custom-select').find('option').not('option[value="unsorted"]').remove();
            $('.custom-select').show();
            $('#answer').find('#selectCategory').show();
        }
    }

    function add_controls(session) {
        $('#answer').on('submit',function(e) {
            e.preventDefault();
            if (typeof username === 'undefined'){
                alert("Username muss gesetzt werden");
                return;
            }
            var msg = $(this).find('textarea').val(),
                cardData = {
                    'user_id': username,
                    'msg': msg
                },
                selectedOption = $(this).closest('form').find('select option:selected').val();
            
            if (parseInt(selectedOption) > 0) {
                cardData.category = selectedOption;
            }
            
            session.publish(client_topic, [cardData]);
            $(this).find('').val('').focus();
            $(this).find('textarea').val('').focus();
        });
    }

    // https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript
    function almost_uuidv4() {
        return 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    $('#stage-session').hide();
    $('#answer').hide();
    $('#stage-waiting').hide();
    $('.loginNav').hide();
    $('#loginByUsername').hide();
});
