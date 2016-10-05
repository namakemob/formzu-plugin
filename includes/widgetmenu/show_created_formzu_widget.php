<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function show_created_formzu_widget() {
    if ( ! FormzuParamHelper::isset_key($_REQUEST, array('action', 'id')) ) {
        return false;
    }

    $widget_name = FormzuParamHelper::get_REQ('name', false);

    if ( ! $widget_name ) {

        $form_data = FormzuOptionHandler::get_option('form_data', array());

        for ($i = 0, $l = count($form_data); $i < $l; $i++) {
            if ( isset($form_data[$i]['id']) && $form_data[$i]['id'] == $_REQUEST['id'] ) {

                $widget_name = $form_data[$i]['name'];

            }
        }

    }
    if ( ! $widget_name ) {
        return false;
    }

?>
<script>
    (function($){
        var widget_name = '<?php echo esc_js($widget_name) ?>';

        if (!widget_name) {
            return false;
        }

        var title_elements = $('.widget-title');

        for (var i = 0, l = title_elements.length; i < l; i++) {
            if ($(title_elements[i]).text() == widget_name) {
                var $elem = $(title_elements[i]);
            }
        }
        $elem.addClass('my-updated');

        var text = $elem.text();

        $elem.children(':first').html('<span class="new-item">NEW!</span>' + text);
        $elem.bind('animationend webkitAnimationEnd oAnimationEnd mozAnimationEnd', function(){
            $elem.removeClass('my-updated');
        });
    })(jQuery);
</script>
<?php
}

