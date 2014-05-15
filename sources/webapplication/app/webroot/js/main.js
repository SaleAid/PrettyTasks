$().ready(function(){

    $('.banner-android-widget button.close').click(function(){
        $.cookie("banner-android-widget-hide", 1, { expires: 7, path: '/' })
    });
    
    window.setTimeout(function() {
        $(".alert-success").fadeTo(1000, 0).slideUp(1000, function(){
            $(this).remove(); 
        });
    }, 5000);

    $('.langList a').click(function(){
        var lang = $(this).attr('data');
        var hash = window.location.hash;
        var url = langUrls[lang] + hash;
        //console.log(url);
        if( isAuth ){
            $.ajax({
                type: "POST",
                data: {lang: lang},
                url: "/users/changeLanguage.json",
                success: function (data) {
                    //if(data.result.success){
                        //window.location.replace(url);
                        //window.location.href = url;
                    //}
                },
                error: function (xhr, ajaxOptions, thrownError) {},
                complete: function(){
                    window.location = url;
                }
            });
        }
        window.location = url;
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

    
});


function __d(domain, key){
		//console.log(translations);
        return (translations[GLOBAL_CONFIG.locale][domain] 			=== undefined ||
        		 translations[GLOBAL_CONFIG.locale][domain] 		=== null ||
        		 translations[GLOBAL_CONFIG.locale][domain][key] 	=== undefined ||
        		 translations[GLOBAL_CONFIG.locale][domain][key]	=== null ||
                 translations[GLOBAL_CONFIG.locale][domain][key]	=== ''
                        )
                        ?
                        key:
                        translations[GLOBAL_CONFIG.locale][domain][key];
};

var __ =function(key){
        return __d('default', key);
};

