<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function formzu_page_button_actions() {
?>
    <script>
        (function($){
            $('#open-formzu-page-button').on('click', function(){
                var url = 'https://ws.formzu.net/new_form.php?dmail=<?php echo esc_attr( get_option( 'admin_email ') ); ?>';
                window.open(url);
            });

            $('#goto-formzu-page-button').on('click', function(){

                var window_width  = $(window).width();
                var window_height = $(window).height();

                if ($('#formzu-iframe-container').length) {

                    var $container = $('#formzu-iframe-container');

                    if ($container.hasClass('hide')) {
                        $container.removeClass('hide').animate({
                            'left': '0'
                        }, 'slow', 'swing', function(){
                            $container.css({'left': '0'});
                            $('html,body').animate({'scrollTop': '0'});
                        });
                    } else {
                        $container.animate({
                            'left': '+=' + window_width
                        }, 'slow').addClass('hide');
                    }
                    return false;
                }

                var $container = $('<div id="formzu-iframe-container">').css({
                    'background-color': 'white',
                    'width'           : '100%',
                    'height'          : window_height,
                    'position'        : 'absolute',
                    'top'             : '0',
                    'left'            : window_width,
                    'border'          : 'solid 1px #777'
                });

                $container.animate({
                    'left': '0'
                }, 'slow', 'swing', function(){
                    $container.css({'left': '0'});
                    $('html,body').animate({'scrollTop': '0'});
                });

                $(window).resize(function(){
                    if ($container.hasClass('hide')) {

                        var window_width = $(window).width();

                        $container.css({'left': window_width});
                    }
                });


                var $close_button = $('<div><i class="fa fa-arrow-right" aria-hidden="true"></i>元の画面へ戻る</div>');

                $close_button.css({
                    'color'        : '#999',
                    'border-bottom': '1px solid #999',
                    'font-size'    : '1.8em',
                    'font-family'  : '"Meiryo","MS PGothic", Arial, "ヒラギノ角ゴ Pro W3", sans-serif',
                    'font-weight'  : 'bold',
                    'padding'      : '4px 16px',
                    'cursor'       : 'pointer',
                    'padding'      : '16px 14px',
                    'left'         : window_width
                }).hover(function(){
                    $(this).css({
                        'color': '#555'
                    });
                }, function(){
                    $(this).css({
                        'color': '#999'
                    });
                });

                $close_button.on('click', function(){
                    var window_width = $(window).width();
                    $container.animate({
                        'left': '+=' + window_width
                    }, 'slow', 'swing', function(){
                        $container.addClass('hide');
                    });
                });

                $container.append($close_button);


                var email = '<?php echo esc_attr( esc_js( get_option( 'admin_email ') ) ); ?>';
                var $iframe = $('<iframe src="https://ws.formzu.net/new_form.php?dmail=' + email + '"></iframe>');

                $iframe.css({
                    'height': '90%',
                    'width' : 'inherit'
                });

                function flashBackButton(cb){
                    var options = {};

                    if (cb) {
                        options.complete = cb;
                    }
                    $close_button.animate({
                        'color': 'white'
                    }).animate({
                        'color': '#555'
                    }, options);
                }

                var load_counter = 0;

                $iframe.load(function(){
                    load_counter++;
                    if (load_counter > 5) {
                        flashBackButton();
                    }
                }).trigger('load');
                $container.append($iframe);

                var $clear = $('<div class="clear"></div>');

                $container.append($clear);
                $('#wpbody-content').append($container);
            });
        })(jQuery);
    </script>
<?php
}

