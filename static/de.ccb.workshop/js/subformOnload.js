$(document).ready(function() {
    if(!$('.element_text').find('#de_ccb_workshop_question').val()){
        setTimeout(function() {
            $('.element_form').find('.remove-item').trigger('click');
            $('.form').find('.element_subform').hide();
        }, 10); 
    }
});