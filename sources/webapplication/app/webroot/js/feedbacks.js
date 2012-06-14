jQuery(function($) {
  $('div.btn-group[data-toggle="buttons-radio"]').each(function(){
    var group   = $(this);
    var hidden  = $('input.category');
    $('button', group).each(function(){
      var button = $(this);
      button.on('click', function(){
          hidden.val($(this).val());
      });
      if(button.val() == hidden.val()) {
        button.addClass('active');
      }
    });
  });
});