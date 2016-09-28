(function($){
    undefined;
    $(function(){

        var email = formzu_ajax_obj.email;

        $('#open-formzu-page-button').on('click', function(){
            var url = 'https://ws.formzu.net/new_form.php?dmail=' + email;
            window.open(url);
        });

        $('#goto-formzu-page-button').on('click', function(){
            var url = 'https://ws.formzu.net/new_form.php?dmail=' + email;
            openFormzuIframeWindow(url);
        });

        $('.formzu-login-button').on('click', function(){
            var url = $(this).attr('data-url');
            var reload_form_id = $(this).attr('data-form-id');
            openFormzuIframeWindow(url, reload_form_id);
        });


        function openFormzuIframeWindow(url, reload_form_id){
            if (!url) {
                return false;
            }

            reload_form_id = getFormIdFromString(reload_form_id); 

            if (!reload_form_id) {
                reload_form_id = null;
            }

            var window_width  = $(window).width();
            var window_height = $(window).height();

            if ($('#formzu-iframe-container').length) {

                var $container = $('#formzu-iframe-container');

                if ($container.attr('data-url') != url) {
                    $container.remove();
                } else if ($container.hasClass('hide')) {
                    $container.removeClass('hide').animate({
                        'left': '0'
                    }, 'slow', 'swing', function(){
                        $container.css({'left': '0'});
                        $('html,body').animate({'scrollTop': '0'});
                    });
                    return false;
                } else {
                    $container.animate({
                        'left': '+=' + window_width
                    }, 'slow').addClass('hide');
                    return false;
                }
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
            $container.attr('data-url', url);

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
                    if (reload_form_id) {
                        alert('フォーム情報を更新します。少々お待ちください。');
                        getReloadFormId(reload_form_id);
                    }
                });
            });

            $container.append($close_button);


            var $iframe = $('<iframe src="' + url + '"></iframe>');

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

            if (reload_form_id) {
                alert('フォーム保存後、画面上部の「元の画面へ戻る」ボタンを押すと自動的に「更新」できます。\nボタンを押した後、更新終了まで少々お待ちください。');
            }
        }


        function submitFormData(form_elem_id, data){
            var html        = data.html;
            var mobile_html = data.mobile_html;
            var form_id     = data.form_id;

            $('<iframe></iframe>').css('width', '100%').load(function(){

                var $ibody = $(this.contentWindow.document.body);

                $ibody.append(html);

                var $google_translate_elem = $ibody.find('#google_translate_element').css('height', '24px');
                var $geo_trust_img         = $('<img />').css('height', '55px');
                var $geo_trust_elem        = $ibody.children().last().children().last();

                if ($geo_trust_elem.prop('tagName') === 'DIV') {
                    $geo_trust_elem.append($('<a></a>').append($geo_trust_img));
                }

                var form            = document.forms[form_elem_id];
                var textarea_length = $ibody.find('textarea').length;
                var height          = $ibody.parent().outerHeight() + 40 + (40 * textarea_length);
                var title           = $ibody.find('title').text();
                var items           = $ibody.find('.itemTitle').map(function(index, elem){
                    return $(elem).text();
                }).get().join();

                form.elements['hidden_height'].value = height;
                form.elements['hidden_id'].value     = form_id;
                form.elements['hidden_title'].value  = title;
                form.elements['hidden_items'].value  = items;

                $(this).remove();

                $('<iframe></iframe>').css('width', '100%').load(function(){

                    var $mobile_ibody = $(this.contentWindow.document.body);
                    $mobile_ibody.append(mobile_html);

                    var $google_translate_elem = $ibody.find('#google_translate_element').css('width', '100%').css('height', '24px');
                    var $geo_trust_img         = $('<img />').css('height', '55px');
                    var $geo_trust_elem        = $ibody.children().last().children().last();

                    if ($geo_trust_elem.prop('tagName') === 'DIV') {
                        $geo_trust_elem.append($('<a></a>').append($geo_trust_img));
                    }

                    var mobile_height = $mobile_ibody.parent().outerHeight() + 40 + 44;//body:padding-top
                    mobile_height++;

                    form.elements['hidden_mobile_height'].value = mobile_height;

                    $(this).remove();
                    $('#' + form_elem_id).submit();
                    return true;
                }).appendTo('body');
            }).appendTo('body');
        }


        function getFormIdFromString(form_id){
            if (!form_id) {
                return false;
            }
            if (form_id.match(/[Ｓｓ０-９]/g)) {
                form_id = form_id.replace(/[Ｓｓ０-９]/g, function(s){
                    return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
                });
            }

            var temp = form_id;
            temp = temp.substr(0, 5);

            if (temp.length >= 5 && !temp.match(/[^0-9]+/)) {
                for (var i = 5, l = 9; i < l; i++) {
                    if (isNaN(form_id[i])) {
                        return 'S' + form_id.substr(0, i);
                    }
                }
                return 'S' + form_id;
            }


            function indexOfAfterKeywords(keywords){
                var inOf;

                for (var i = 0, l = keywords.length; i < l; i++) {
                    inOf = form_id.indexOf(keywords[i]);
                    if (inOf != -1) {
                        break;
                    }
                }
                if (inOf != -1) {

                    var result = inOf + keywords[i].length;

                    if (result > 0) {
                        return result;
                    }
                }
                return false;
            }

            var keywords = ['gen/S', 'en/S', 'n/S', '/S', 'S'];
            var inOf_key = indexOfAfterKeywords(keywords);

            if (inOf_key) {

                var temp;

                for (var i = 8, l = 5; i >= l; i--) {
                    temp = form_id.substr(inOf_key, i);
                    if (temp.length == i && !temp.match(/[^0-9]+/)) {
                        return 'S' + temp;
                    }
                }
            }
            return false;
        }


        $('.formzu-reload-button').click(getReloadFormId);

        function getReloadFormId(reload_form_id){
            var form_id;
            var from_str;

            if (typeof reload_form_id == 'string') {
                form_id = reload_form_id;
            } else {
                form_id = $(this).attr('data-form-id');
                form_id = getFormIdFromString(form_id);
            }

            if (!form_id) {
                alert("フォームID : " + form_id + "\n無効な値が入力されました。正確な値を入力してください。");
                return false;
            }

            var $this = $(this);

            if ($this.prop('tagName')) {
                $this.off('click');
                $this.after('<p><i class="fa fa-refresh fa-spin" aria-hidden="true"></i>フォーム情報取得中...</p>');
            } else {
                $('.wrap').first().prepend('<div style="font-size: 2em;"><i class="fa fa-refresh fa-spin" aria-hidden="true"></i>フォーム情報取得中...</div>');
            }

            $.ajax({
                type: "POST",
                url: formzu_ajax_obj.ajaxurl,
                dataType: "json",
                data: {
                    "id": form_id,
                    "security": formzu_ajax_obj.nonce,
                    "action": formzu_ajax_obj.action
                },
                timeout: 30000,
                success: function(response, dataType){
                    var html        = $.parseHTML(response[0]);
                    var mobile_html = $.parseHTML(response[1]);

                    if (!html || !mobile_html) {
                        alert("フォームID : " + form_id + "\nフォームが見つかりませんでした。");
                        $('.fa-refresh').parent().remove();
                        $('.formzu-reload-button').click(getReloadFormId);
                        return false;
                    }
                    submitFormData('reload-form-data', {
                        "form_id": form_id,
                        "html": html,
                        "mobile_html": mobile_html
                    });
                },
                error: function(XMLHttpRequest, textStatus, error){
                    console.error(error);
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                }
            });
            return false;
        }


        $add_new_form = $('#add-new-form-data');

        function getNewFormId(){
            var form = document.forms['add-new-form-data'];

            if (!form) {
                return false;
            }

            var form_id = form.elements['form_id_URL'].value;

            if (!form.elements['form_id_URL']) {
                return false;
            }

            form_id = getFormIdFromString(form_id);

            if (!form_id) {
                alert("フォームID : " + form_id + "\n無効な値が入力されました。正確な値を入力してください。");
                return false;
            }
            $('#add-new-form-submit').off('click');

            var $input = $('#add-new-form-input');

            $input.off('keypress');
            $input.keypress(function(e){
                e.preventDefault();
                return false;
            });
            $add_new_form.after('<p><i class="fa fa-refresh fa-spin" aria-hidden="true"></i>フォーム情報取得中...</p>');

            $.ajax({
                type: "POST",
                url: formzu_ajax_obj.ajaxurl,
                dataType: "json",
                data: {
                    "id": form_id,
                    "security": formzu_ajax_obj.nonce,
                    "action": formzu_ajax_obj.action
                },
                success: function(response){
                    var html        = $.parseHTML(response[0]);
                    var mobile_html = $.parseHTML(response[1]);

                    if (!html || !mobile_html) {
                        alert('フォームID : ' + form_id + '\nフォームが見つかりませんでした。');
                        $('.fa-refresh').parent().remove();
                        $('#add-new-form-submit').click(getNewFormId);

                        var $input = $('#add-new-form-input');

                        $input.off('keypress');
                        $input.keypress(getNewFormIdFromEnterKey);
                        return false;
                    }
                    submitFormData('add-new-form-data', {"form_id": form_id, "html": html, "mobile_html": mobile_html});
                },
                error: function(XMLHttpRequest, textStatus, error){
                    console.error(error);
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                }
            });
            return false;
        }


        function getNewFormIdFromEnterKey(e){
            if (e.keyCode == 13) {
                e.preventDefault();
                getNewFormId();
            }
        }

        $('#add-new-form-submit').click(getNewFormId);
        $('#add-new-form-input').keypress(getNewFormIdFromEnterKey);
    });
})(jQuery);

