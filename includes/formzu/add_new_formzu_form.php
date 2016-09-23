<?php

function add_new_formzu_form() {
    //新しいフォームを登録
    if ( ! FormzuParamHelper::check_referer('formzu-new-form-save', 'add-new-form') ) {
        return false;
    }

    $form_id = FormzuParamHelper::get_POS('form_id_URL', 'none');

    if ($form_id == 'none') {
        $message = 'ERROR: 10';
        set_transient( 'formzu-admin-errors', $message, 3 );
    }

    $form_id = FormzuParamHelper::get_POS('hidden_id', $form_id);
    $form_height = FormzuParamHelper::get_POS('hidden_height', 600);
    $form_mobile_height = FormzuParamHelper::get_POS('hidden_mobile_height', 700);
    $form_data = FormzuOptionHandler::get_option('form_data', array());
    $form_name = FormzuParamHelper::get_POS('hidden_title', 'Noname');
    $form_items = FormzuParamHelper::get_POS('hidden_items', 'Noitems');
    $form_number = count($form_data);

    //TODO: wordpressのキャッシュを使ってフォームを表示させてみる（キャッシュの更新はどうする？）
    //同じＩＤがあれば上書き
    for ($i = 0; $i < $form_number; $i++) {
        if ( isset($form_data[$i]['id']) && $form_data[$i]['id'] == $form_id ) {

            $message = __('同じIDのフォーム（', 'formzu-admin') . $form_data[$i]['name'] . __('）が、新しいフォーム（', 'formzu-admin') . '<a href="https://ws.formzu.net/fgen/' . $form_id . '" target="_blank">' . $form_name . '</a>' . __('）によって上書きされました。', 'formzu-admin');
            $same_id_number = $i;

            break;
        }
    }

    $form_number = count($form_data);
    $new_data = array(
        'id'            => $form_id,
        'name'          => $form_name,
        'number'        => $form_number,
        'items'         => $form_items,
        'height'        => $form_height,
        'mobile_height' => $form_mobile_height,
    );

    if ( isset($same_id_number) ) {
        array_splice($form_data, $same_id_number, 1, array($new_data));
    }
    else {
        $form_data[] = $new_data;
    }

    if ( ! isset($message) ) {
        $message = __( 'フォーム : ', 'formzu-admin' ) . '<a href="https://ws.formzu.net/fgen/' . $form_id . '" target="_blank">' . $form_name . '</a>' . __('を追加しました。フォーム一覧を確認してください。', 'formzu-admin');
    }
    set_transient( 'formzu-admin-updated', $message, 3 );
    FormzuOptionHandler::update_option( 'form_data', $form_data );
    wp_safe_redirect( menu_page_url( 'formzu-admin' ) . '&action=added&number=' . $form_number );
    exit;
}

