<?php

function echo_formzu_admin_page() {
    $screen = get_current_screen();
    $page = $screen->id;

    wp_enqueue_script('common');
    wp_enqueue_script('wp-lists');
    wp_enqueue_script('postbox');

    ?>
        <div class="wrap">
            <h2>フォーム管理（フォームズ）</h2>
            <i class="fa fa-sign-in"></i><a href="http://www.formzu.com" target="_blank">フォームズトップページ</a>


            <div id="poststuff" class="metabox-holder">
                <div class="postbox-conteiner formzu-container">
                    <form id="postbox-wrap-form" method="get" action="">
                    </form>
                        <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
                        <?php wp_nonce_field('meta-box-order',  'meta-box-order-nonce', false); ?>

                        <?php add_meta_box('formzu-create-box', '<span class="box-icon">1<i class="fa fa-external-link" aria-hidden="true"></i></span>' . __(' フォームズへ移動して新しくフォームを作成します（別ページ）', 'formzu-admin'), 'echo_create_formzu_form_body', $page); ?>
                        <?php add_meta_box('formzu-add-box',    '<span class="box-icon">2<i class="fa fa-plus" aria-hidden="true"></i></span>' . __(' フォームズで作成したフォームIDを入力してください', 'formzu-admin'), 'echo_add_formzu_form_body', $page); ?>
                        <?php add_meta_box('formzu-list-box',   '<span class="box-icon">3<i class="fa fa-list" aria-hidden="true"></i></span>' . __(' フォーム一覧', 'formzu-admin'), 'echo_formzu_list_body', $page); ?>

                        <?php do_meta_boxes($page, 'advanced', null); ?>
                </div>
            </div>


            <script type="text/javascript">
                (function($){
                    $(document).ready(function($){
                        $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                        postboxes.add_postbox_toggles('<?php echo $page; ?>');

                        $('#formzu-add-box .hndle').on('click', function(e){
                            if (!$(this).parent().hasClass('closed')) {
                                $('#add-new-form-input').focus();
                            }
                        });

                        function addArrow(){
                            var $table      = $('#advanced-sortables').find('.postbox');
                            var $create_box = $('#formzu-create-box');
                            var $add_box    = $('#formzu-add-box');

                            var create_box_index = $table.index($create_box);
                            var add_box_index    = $table.index($add_box);
                            var list_box_index   = $table.index($('#formzu-list-box'));

                            var correct_order = create_box_index < add_box_index && add_box_index < list_box_index;
                            if (correct_order) {
                                if ($('.separate-arrow').length) {
                                    return;
                                }
                                var separate_arrow = '<div class="separate-arrow"><i class="fa fa-caret-down fa-5x" aria-hidden="true"></i></div>';
                                var separate_box = '<div class="separate-box">'
                                    + '<div class="formzu-mail-icon">'
                                    + '<i class="fa fa-envelope-o fa-2x" aria-hidden="true"></i>'
                                    + '<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>'
                                    + '</div>'
                                    + '<span>フォーム作成通知メールのフォームIDを確認してください</span>'
                                    + '</div>';

                                $create_box.css('margin-bottom', '0')
                                    .after(separate_arrow)
                                    .after(separate_box)
                                    .after($(''))
                                    .after(separate_arrow);
                                $add_box.css('margin-bottom', '0').after(separate_arrow);
                            } else {
                                $('.separate-arrow').remove();
                                $('.separate-box').remove();
                                $create_box.css('margin-bottom', '50px');
                                $add_box.css('margin-bottom', '50px');
                            }
                        }

                        addArrow();
                        $('#advanced-sortables').bind('sortstop', function(e, ui){
                            addArrow();
                        });
                    });
                })(jQuery);
            </script>


        </div>
    <?php
}


function echo_create_formzu_form_body() {
?>
    <div class="panel">
        <div class="panel-content">

            <div id="open-formzu-page-button" class="large-button" style="margin: 0 0 20px 0;">別タブでフォームズを表示する</div>
            <div id="goto-formzu-page-button" class="large-button">同じ画面でフォームズを表示する</div>
            <?php formzu_page_button_actions(); ?>

        </div>
    </div>
<?php
}


function echo_add_formzu_form_body() {
?>
    <div class="panel">
        <div class="panel-content">
            <div><form id="dummy-form"></form></div>
            <!-- フォームが消されてしまうので、↑にダミーを設置 -->
            <!-- postbox-wrap-formにここのformが内包されてしまっているせいで消されてしまう。別の箇所にhiddenで設置する -->

            <form id="add-new-form-data" method="post" action="" style="margin: 0">
                <?php wp_nonce_field( 'formzu-new-form-save', 'add-new-form' ); ?>
                <label>
                    <span style="font-size: 1.8em; margin: 0 8px 0 0;">フォームID</span>
                    <input type="text" id="add-new-form-input" name="form_id_URL" placeholder="例）S12345678">
                </label>
                <span id="add-new-form-submit" class="large-button" style="padding:13px 12px 11px;">設定する</span>
                <div style="display: inline-block; width: 100%;">
                    <span style="margin: 0 0 0 132px;">※フォームURLも入力できます。</span>
                </div>
                <input type="hidden" name="hidden_id" value="" />
                <input type="hidden" name="hidden_height" value="" />
                <input type="hidden" name="hidden_mobile_height" value="" />
                <input type="hidden" name="hidden_title" value="" />
                <input type="hidden" name="hidden_items" value="" />
            </form>

        </div>
    </div>

<?php
}


function echo_formzu_list_body() {
    $form_data = FormzuOptionHandler::get_option( 'form_data' );
    $list_table = new FormzuListTable();

    if (isset($_POST['s'] )){
        $list_table->prepare_items($_POST['s']);
    }
    else {
        $list_table->prepare_items();
    }

?>
    <?php if ( ! empty( $_REQUEST['s'] ) ) {
        echo sprintf( '<span class="subtitle"> ' . __( '検索結果：', 'formzu-admin' ) . '%s </span>', esc_html( $_REQUEST['s'] ) );
    }?>
    <form id="forms-filter" method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $list_table->search_box( __( '検索', 'formzu-admin' ), 'formzu_search'); ?>
        <?php $list_table->display(); ?>
    </form>
    
        <form id="reload-form-data" method="post" action="">
            <?php wp_nonce_field( 'formzu-reload-form-save', 'reload-form-data' ); ?>
            <input type="hidden" name="hidden_id" value="" />
            <input type="hidden" name="hidden_height" value="" />
            <input type="hidden" name="hidden_mobile_height" value="" />
            <input type="hidden" name="hidden_title" value="" />
            <input type="hidden" name="hidden_items" value="" />
        </form>
<?php
}

