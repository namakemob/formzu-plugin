(function($){
    function resizeThickbox(){

        var window_height = window.innerHeight
            || (document.documentElement && document.documentElement.clientHeight)
            || document.body.clientHeight;

        window_height -= 100;

        $('.thickbox').each(function(index, elem){

            var href = $(elem).attr('href');

            if (!href || typeof href != 'string') {
                return true;//jQuery continue
            }

            var splited_href = href.split('&height=');

            if (!splited_href[1]) {
                return true;//jQuery continue
            }

            var thickbox_height = splited_href[1].split('&')[0];

            if (thickbox_height.match(/[^0-9]+/)) {
                return true;//jQuery continue
            }

            var origin_height = $(elem).attr('data-origin-height');

            if (Number(thickbox_height) < origin_height) {
                thickbox_height = origin_height;
            }
            if (Number(thickbox_height) <= window_height) {
                return true;
            }

            thickbox_height = window_height;
            var href_before_height = splited_href[0];
            var href_after_height = splited_href[1].split('&')[1];

            $(elem).attr('href', function(){

                var new_href = href_before_height + '&height=' + window_height;

                if (href_after_height) {
                    new_href += href_after_height;
                }
                return new_href;
            });
        });
    }
    resizeThickbox();

    var resize_timeout = false;

    $(window).resize(function(){
        if (resize_timeout !== false) {
            clearTimeout(resize_timeout);
        }
        resize_timeout = setTimeout(function(){
            resizeThickbox();
        }, 200);
    });
})(jQuery);

