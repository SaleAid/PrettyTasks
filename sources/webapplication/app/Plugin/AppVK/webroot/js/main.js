
$().ready(function(){
    window.setTimeout(function() {
        $(".alert-success").fadeTo(1000, 0).slideUp(1000, function(){
            $(this).remove(); 
        });
    }, 5000);

    $('.langList a').click(function(){
        var lang = $(this).attr('data');
        var hash = window.location.hash;
        var url = langUrls[lang] + hash;
        if( isAuth ){
            $.ajax({
                type: "POST",
                data: {lang: lang},
                url: "/users/changeLanguage.json",
                success: function (data) {
                    if(data.result.success){
                        window.location.replace(url);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {}
            });
        }
        window.location.replace(url);
        return false;
    });
    
    $('.share').click(function (event){
        var url = $(this).attr("href");
        var windowName = "Share";
        var width = 600;
        var height = 400;
        var left = parseInt((screen.availWidth/2) - (width/2));
        var top = parseInt((screen.availHeight/2) - (height/2));
        var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
        window.open(url, windowName, windowFeatures);
        event.preventDefault();
    });
    
    $(window).on("resize load", function () {
        if ( $(this).width() <= 1030 ) {
            $('#box').addClass('hide');
        }else {
            $('#box').removeClass('hide');
        }
    });
    
    $('.btn-note').tooltip({placement:'bottom',delay: { show: 500, hide: 100 }});
    console.log(window.location);
    if (window.location==top.location) {
        console.log(window.location);
        //window.location='thispage.php?vk=1';
    }
            
});