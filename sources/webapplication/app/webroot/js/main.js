
$(document).ready(function(){
    window.setTimeout(function() {
        $(".alert-success").fadeTo(1000, 0).slideUp(1000, function(){
            $(this).remove(); 
        });
    }, 5000);

    $('.langList a').click(function(){
        console.log(this);
        var lang = $(this).attr('data');
        var hash = window.location.hash;
        var pathname = window.location.pathname.slice(3);
        var url = '/'+lang+pathname + hash;
        window.location.replace(url);
        return false;
    });
});