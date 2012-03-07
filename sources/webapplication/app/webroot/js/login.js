
$(document).ready(function(){
    $('#name').blur(function(){
        $.post(
            '/cake1/messages/validate_form',
            {field: $('#name').attr('id'), value: $('#name').val()},
            handleNameValidate
        );
    });
    
    function handleNameValidate(error){
        if(error.length > 0 ){
            //alert($('#name-error').length);
            if($('#name-error').length == 0){
                $('#name').after('<div id="name-error">'+ error + '<div>');
            }
        }else{
            $('#name-error').remove();
        }
    }
});